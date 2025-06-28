<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseBookingRequest;
use App\Http\Requests\UpdateCourseBookingRequest;
use App\Models\CourseBooking;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CourseBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = CourseBooking::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when(Auth::user()->role === 'mentee', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->when(Auth::user()->role === 'mentor', function ($query) {
                $query->whereHas('course', function ($query) {
                    $query->where('mentor_id', Auth::user()->id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('apps.course-bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();

        return view('apps.course-bookings.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseBookingRequest $request)
    {
        try {
            // validate request
            $validated = $request->validated();

            // upload payment proof
            if ($request->hasFile('payment_proof')) {
                $paymentProof = $request->file('payment_proof');
                $validated['payment_proof'] = Storage::disk('public')->put(CourseBooking::PAYMENT_PROOF_PATH, $paymentProof);
            }

            $courseBooking = CourseBooking::make($validated);
            $courseBooking->user_id = Auth::user()->id;
            $courseBooking->saveOrFail();

            return redirect()->route('course-bookings.index')->with('success', 'Pemesanan kursus berhasil dibuat');
        } catch (\Exception $e) {
            // log error
            Log::error('Error creating course booking: ' . $e->getMessage());
            
            return redirect()->route('course-bookings.index')->with('error', 'Pemesanan kursus gagal dibuat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseBooking $courseBooking)
    {
        return view('apps.course-bookings.show', compact('courseBooking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseBooking $courseBooking)
    {
        return view('apps.course-bookings.edit', compact('courseBooking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseBookingRequest $request, CourseBooking $courseBooking)
    {
        try {
            // validate request
            $validated = $request->validated();

            // upload payment proof
            if ($request->hasFile('payment_proof')) {
                $paymentProof = $request->file('payment_proof');
                $validated['payment_proof'] = Storage::disk('public')->put(CourseBooking::PAYMENT_PROOF_PATH, $paymentProof);
            }

            // update course booking
            $courseBooking->fill($validated);
            $courseBooking->saveOrFail();

            return redirect()->route('course-bookings.index')->with('success', 'Pemesanan kursus berhasil diubah');
        } catch (\Exception $e) {
            // log error
            Log::error('Error updating course booking: ' . $e->getMessage());
            
            return redirect()->route('course-bookings.index')->with('error', 'Pemesanan kursus gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseBooking $courseBooking)
    {
        try {
            // delete payment proof
            if ($courseBooking->payment_proof) {
                Storage::disk('public')->delete($courseBooking->payment_proof);
            }

            // delete course booking
            $courseBooking->deleteOrFail();

            return redirect()->route('course-bookings.index')->with('success', 'Pemesanan kursus berhasil dihapus');
        } catch (\Exception $e) {
            // log error
            Log::error('Error deleting course booking: ' . $e->getMessage());
            
            return redirect()->route('course-bookings.index')->with('error', 'Pemesanan kursus gagal dihapus');
        }
    }

    /**
     * Approve the specified resource from storage.
     * 
     * @param CourseBooking $courseBooking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(CourseBooking $courseBooking)
    {
        try {
            $courseBooking->status = 'approved';
            $courseBooking->saveOrFail();

            return redirect()->route('course-bookings.index')->with('success', 'Pemesanan kursus berhasil disetujui');
        } catch (\Exception $e) {
            // log error
            Log::error('Error approving course booking: ' . $e->getMessage());
            
            return redirect()->route('course-bookings.index')->with('error', 'Pemesanan kursus gagal disetujui');
        }
    }

    /**
     * Reject the specified resource from storage.
     * 
     * @param CourseBooking $courseBooking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(CourseBooking $courseBooking)
    {
        try {
            $courseBooking->status = 'rejected';
            $courseBooking->saveOrFail();

            return redirect()->route('course-bookings.index')->with('success', 'Pemesanan kursus berhasil ditolak');
        } catch (\Exception $e) {
            // log error
            Log::error('Error rejecting course booking: ' . $e->getMessage());
            
            return redirect()->route('course-bookings.index')->with('error', 'Pemesanan kursus gagal ditolak');
        }
    }
}

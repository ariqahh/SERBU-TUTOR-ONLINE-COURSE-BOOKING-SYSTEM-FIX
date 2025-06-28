<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::query()
            ->with(['mentor', 'bookings'])
            ->withCount('bookings')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('mentor', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when(Auth::user()->role === 'mentor', function ($query) {
                $query->where('mentor_id', Auth::user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);
        
        return view('apps.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentors = User::where('role', 'mentor')->get();

        return view('apps.courses.create', compact('mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            // validate request
            $validated = $request->validated();

            // upload image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $validated['image'] = Storage::disk('public')->put(Course::IMAGE_PATH, $image);
            }

            // create course
            $course = Course::make($validated);
            $course->saveOrFail();

            return redirect()->route('courses.index')->with('success', 'Kursus berhasil dibuat');
        } catch (\Exception $e) {
            // log error
            Log::error('Error creating course: ' . $e->getMessage());
            
            return redirect()->route('courses.index')->with('error', 'Kursus gagal dibuat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('apps.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $mentors = User::where('role', 'mentor')->get();

        return view('apps.courses.edit', compact('course', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $validated = $request->validated();

            // upload image
            if ($request->hasFile('image')) {
                // delete old image
                if ($course->image) {
                    Storage::disk('public')->delete($course->image);
                }

                $image = $request->file('image');
                $validated['image'] = Storage::disk('public')->put(Course::IMAGE_PATH, $image);
            }

            $course->fill($validated);
            $course->saveOrFail();

            return redirect()->route('courses.index')->with('success', 'Kursus berhasil diubah');
        } catch (\Exception $e) {
            // log error
            Log::error('Error updating course: ' . $e->getMessage());
            
            return redirect()->route('courses.index')->with('error', 'Kursus gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            // delete image
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $course->deleteOrFail();

            return redirect()->route('courses.index')->with('success', 'Kursus berhasil dihapus');
        } catch (\Exception $e) {
            // log error
            Log::error('Error deleting course: ' . $e->getMessage());
            
            return redirect()->route('courses.index')->with('error', 'Kursus gagal dihapus');
        }
    }

    /**
     * Handle batch approval/rejection of course bookings.
     */
    public function batchAction(Request $request, Course $course)
    {
        try {
            // validate request
            $request->validate([
                'action' => 'required|in:approve,reject',
                'bookings' => 'required|array',
                'bookings.*' => 'exists:course_bookings,id'
            ]);

            // get bookings
            $bookings = $course->bookings()->whereIn('id', $request->bookings)->get();

            // begin transaction
            DB::beginTransaction();

            foreach ($bookings as $booking) {
                if ($booking->status !== 'pending') {
                    continue;
                }

                if ($request->action === 'approve') {
                    $booking->status = 'approved';
                } else {
                    $booking->status = 'rejected';
                }

                $booking->saveOrFail();
            }

            // commit transaction
            DB::commit();

            $message = $request->action === 'approve' ? 'disetujui' : 'ditolak';
            return redirect()->back()->with('success', 'Booking berhasil ' . $message);
        } catch (\Exception $e) {
            // rollback transaction
            DB::rollBack();

            // log error
            Log::error('Error batch ' . $request->action . ' bookings: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses booking');
        }
    }
}

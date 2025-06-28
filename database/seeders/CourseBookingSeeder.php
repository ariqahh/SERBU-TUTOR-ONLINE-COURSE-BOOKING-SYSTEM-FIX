<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all courses
        $courses = Course::all();
        
        // Get all mentee users
        $mentees = User::where('role', 'mentee')->get();
        
        // Possible status values with weighted probability
        $statuses = [
            'pending' => 30,    // 30% chance
            'approved' => 50,   // 50% chance
            'rejected' => 20    // 20% chance
        ];

        // Generate 50 bookings
        for ($i = 0; $i < 50; $i++) {
            // Random course
            $course = $courses->random();
            
            // Random mentee (excluding the course mentor)
            $mentee = $mentees->where('id', '!=', $course->mentor_id)->random();

            // Random status based on weighted probability
            $status = $this->getRandomWeightedElement($statuses);

            // Random date within last 30 days
            $date = Carbon::now()->subDays(rand(0, 30));

            // Create booking
            CourseBooking::create([
                'course_id' => $course->id,
                'user_id' => $mentee->id,
                'status' => $status,
                'created_at' => $date,
                'updated_at' => $status !== 'pending' ? $date->addHours(rand(1, 24)) : $date
            ]);
        }
    }

    /**
     * Get random element based on weights.
     *
     * @param array $elements Array of element => weight pairs
     * @return string
     */
    private function getRandomWeightedElement(array $elements): string
    {
        $total = array_sum($elements);
        $random = rand(1, $total);

        foreach ($elements as $element => $weight) {
            $random -= $weight;
            if ($random <= 0) {
                return $element;
            }
        }

        return array_key_first($elements);
    }
}

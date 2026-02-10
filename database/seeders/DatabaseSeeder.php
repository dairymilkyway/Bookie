<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Book;
use App\Models\BookAssignment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Create sample teacher
        $teacher = User::create([
            'name' => 'John Teacher',
            'username' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->roles()->attach(Role::where('role_name', 'Teacher')->first()->id);

        // Create sample students
        $student1 = User::create([
            'name' => 'Jane Student',
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $student1->roles()->attach(Role::where('role_name', 'Student')->first()->id);

        $student2 = User::create([
            'name' => 'Bob Learner',
            'username' => 'student2',
            'email' => 'student2@example.com',
            'password' => bcrypt('password'),
        ]);
        $student2->roles()->attach(Role::where('role_name', 'Student')->first()->id);

        $student3 = User::create([
            'name' => 'Alice Reader',
            'username' => 'student3',
            'email' => 'student3@example.com',
            'password' => bcrypt('password'),
        ]);
        $student3->roles()->attach(Role::where('role_name', 'Student')->first()->id);

        // Create sample books for the teacher
        $books = [
            [
                'title' => 'Introduction to Computer Science',
                'description' => 'A comprehensive guide covering the fundamentals of computer science, including algorithms, data structures, and problem-solving strategies. Perfect for beginners who want to build a strong foundation.',
                'created_by' => $teacher->id,
            ],
            [
                'title' => 'Web Development with Laravel',
                'description' => 'Learn modern web development using the Laravel PHP framework. Covers routing, controllers, Eloquent ORM, Blade templates, middleware, and building RESTful APIs.',
                'created_by' => $teacher->id,
            ],
            [
                'title' => 'Database Design Principles',
                'description' => 'Master the art of designing efficient and scalable databases. Topics include normalization, ER diagrams, indexing strategies, and query optimization techniques.',
                'created_by' => $teacher->id,
            ],
            [
                'title' => 'JavaScript: The Complete Guide',
                'description' => 'From basics to advanced topics — closures, promises, async/await, ES6+ features, and DOM manipulation. Build interactive web applications with confidence.',
                'created_by' => $teacher->id,
            ],
            [
                'title' => 'Data Structures & Algorithms',
                'description' => 'A practical approach to understanding arrays, linked lists, trees, graphs, sorting, searching and dynamic programming. Includes exercises and real-world examples.',
                'created_by' => $teacher->id,
            ],
        ];

        $createdBooks = [];
        foreach ($books as $bookData) {
            $createdBooks[] = Book::create($bookData);
        }

        // Assign some books to students
        BookAssignment::create([
            'book_id' => $createdBooks[0]->id,
            'student_id' => $student1->id,
            'teacher_id' => $teacher->id,
        ]);
        BookAssignment::create([
            'book_id' => $createdBooks[1]->id,
            'student_id' => $student1->id,
            'teacher_id' => $teacher->id,
        ]);
        BookAssignment::create([
            'book_id' => $createdBooks[2]->id,
            'student_id' => $student1->id,
            'teacher_id' => $teacher->id,
        ]);
        BookAssignment::create([
            'book_id' => $createdBooks[0]->id,
            'student_id' => $student2->id,
            'teacher_id' => $teacher->id,
        ]);
        BookAssignment::create([
            'book_id' => $createdBooks[3]->id,
            'student_id' => $student3->id,
            'teacher_id' => $teacher->id,
        ]);
    }
}

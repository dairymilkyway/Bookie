<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing teachers or create one
        $teacher = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('username', 'teacher');
        })->first();

        if (!$teacher) {
            $teacher = \App\Models\User::factory()->create([
                'username' => 'teacher',
                'email' => 'teacher@example.com',
                'password' => bcrypt('password'),
            ]);
            $teacher->roles()->attach(\App\Models\Role::where('name', 'teacher')->first());
        }

        $books = [
            // Science Fiction
            [
                'title' => 'Dune',
                'description' => 'A mythic and emotionally charged hero\'s journey, Dune tells the story of Paul Atreides, a brilliant and gifted young man born into a great destiny beyond his understanding.',
                'category' => 'Science Fiction',
            ],
            [
                'title' => 'Ender\'s Game',
                'description' => 'Andrew "Ender" Wiggin thinks he is playing computer simulated war games; he is, in fact, engaged in something far more desperate.',
                'category' => 'Science Fiction',
            ],
            // Fantasy
            [
                'title' => 'The Hobbit',
                'description' => 'A withdrawn hobbit, Bilbo Baggins, joins a company of dwarves to reclaim their mountain home from a dragon.',
                'category' => 'Fantasy',
            ],
            [
                'title' => 'The Name of the Wind',
                'description' => 'The story of Kvothe, a magically gifted young man who grows to be the most notorious wizard his world has ever seen.',
                'category' => 'Fantasy',
            ],
            // History
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'description' => 'A brief history of humankind, from the Stone Age to the twenty-first century.',
                'category' => 'History',
            ],
            [
                'title' => 'Guns, Germs, and Steel',
                'description' => 'A short history of everybody for the last 13,000 years.',
                'category' => 'History',
            ],
            // Technology
            [
                'title' => 'Clean Code',
                'description' => 'Even bad code can function. But if code isn\'t clean, it can bring a development organization to its knees.',
                'category' => 'Technology',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'description' => 'Written as a series of self-contained sections and filled with classic and fresh anecdotes, thoughtful examples, and interesting analogies.',
                'category' => 'Technology',
            ],
            // Mystery
            [
                'title' => 'The Girl with the Dragon Tattoo',
                'description' => 'Harriet Vanger, a scion of one of Sweden\'s wealthiest families disappeared over forty years ago.',
                'category' => 'Mystery',
            ],
            [
                'title' => 'Gone Girl',
                'description' => 'On a warm summer morning in North Carthage, Missouri, it is Nick and Amy Dunne\'s fifth wedding anniversary.',
                'category' => 'Mystery',
            ],
        ];

        foreach ($books as $book) {
            \App\Models\Book::firstOrCreate(
            ['title' => $book['title']],
                array_merge($book, ['created_by' => $teacher->id])
            );
        }
    }
}

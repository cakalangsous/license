<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds for demo environment.
     */
    public function run(): void
    {
        $this->createDemoUser();
        $this->createDemoCategories();
        $this->createDemoTags();
        $this->createDemoPosts();
    }

    /**
     * Create demo user account
     */
    protected function createDemoUser(): void
    {
        $demoUser = User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'avatar' => null,
            'password' => bcrypt('demo123'),
        ]);

        $demoUser->assignRole('Admin');
    }

    /**
     * Create demo categories
     */
    protected function createDemoCategories(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Latest technology news and updates',
            ],
            [
                'name' => 'Development',
                'description' => 'Web development tutorials and tips',
            ],
            [
                'name' => 'Design',
                'description' => 'UI/UX design trends and best practices',
            ],
            [
                'name' => 'Business',
                'description' => 'Business insights and strategies',
            ],
            [
                'name' => 'Tutorial',
                'description' => 'Step-by-step guides and tutorials',
            ],
        ];

        foreach ($categories as $category) {
            PostCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }

    /**
     * Create demo tags
     */
    protected function createDemoTags(): void
    {
        $tags = [
            'Laravel', 'Vue.js', 'PHP', 'JavaScript', 'Tailwind CSS',
            'API', 'Database', 'Security', 'Performance', 'Docker',
            'Git', 'Testing', 'Frontend', 'Backend', 'Full Stack',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }

    /**
     * Create demo posts
     */
    protected function createDemoPosts(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $categories = PostCategory::all();
        $tags = Tag::all();

        $posts = [
            [
                'title' => 'Getting Started with Laravel 12',
                'content' => $this->generatePostContent('Laravel 12'),
                'excerpt' => 'Learn the basics of Laravel 12 and discover the new features that make it the best PHP framework for modern web development.',
                'category' => 'Development',
            ],
            [
                'title' => 'Building Modern UIs with Vue 3 and Tailwind CSS',
                'content' => $this->generatePostContent('Vue 3 and Tailwind CSS'),
                'excerpt' => 'Discover how to create beautiful, responsive user interfaces using Vue 3 composition API and Tailwind CSS utility classes.',
                'category' => 'Design',
            ],
            [
                'title' => 'API Development Best Practices',
                'content' => $this->generatePostContent('API Development'),
                'excerpt' => 'Master the art of building robust, scalable APIs with proper authentication, validation, and error handling.',
                'category' => 'Development',
            ],
            [
                'title' => 'Database Optimization Techniques',
                'content' => $this->generatePostContent('Database Optimization'),
                'excerpt' => 'Improve your application performance with these proven database optimization strategies and indexing techniques.',
                'category' => 'Technology',
            ],
            [
                'title' => 'Securing Your Laravel Application',
                'content' => $this->generatePostContent('Laravel Security'),
                'excerpt' => 'Protect your Laravel application from common vulnerabilities with these essential security practices.',
                'category' => 'Technology',
            ],
            [
                'title' => 'Introduction to Inertia.js',
                'content' => $this->generatePostContent('Inertia.js'),
                'excerpt' => 'Learn how Inertia.js bridges the gap between server-side and client-side rendering for a seamless SPA experience.',
                'category' => 'Tutorial',
            ],
            [
                'title' => 'Building a CRUD Generator',
                'content' => $this->generatePostContent('CRUD Generator'),
                'excerpt' => 'Automate your development workflow by building a powerful CRUD generator that creates models, controllers, and views.',
                'category' => 'Tutorial',
            ],
            [
                'title' => 'Modern Authentication Strategies',
                'content' => $this->generatePostContent('Authentication'),
                'excerpt' => 'Explore modern authentication methods including OAuth, JWT, and two-factor authentication implementation.',
                'category' => 'Technology',
            ],
        ];

        foreach ($posts as $index => $postData) {
            $category = $categories->where('name', $postData['category'])->first();

            $post = Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'content' => $postData['content'],
                'excerpt' => $postData['excerpt'],
                'post_category_id' => $category?->id,
                'author_id' => $admin?->id,
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Attach random tags
            $randomTags = $tags->random(rand(2, 5));
            $post->tags()->attach($randomTags->pluck('id'));
        }
    }

    /**
     * Generate sample post content
     */
    protected function generatePostContent(string $topic): string
    {
        return <<<HTML
<h2>Introduction to {$topic}</h2>
<p>Welcome to this comprehensive guide on {$topic}. In this article, we'll explore the fundamental concepts and best practices that will help you master this technology.</p>

<h3>Why {$topic} Matters</h3>
<p>Understanding {$topic} is crucial for modern web development. It provides the foundation for building scalable, maintainable, and performant applications that meet today's user expectations.</p>

<h3>Key Features</h3>
<ul>
    <li>Easy to learn and implement</li>
    <li>Excellent documentation and community support</li>
    <li>Regular updates and improvements</li>
    <li>Battle-tested in production environments</li>
</ul>

<h3>Getting Started</h3>
<p>To begin working with {$topic}, you'll need to set up your development environment. Follow these steps to get started quickly:</p>

<ol>
    <li>Install the required dependencies</li>
    <li>Configure your project settings</li>
    <li>Create your first component</li>
    <li>Test and iterate on your implementation</li>
</ol>

<h3>Best Practices</h3>
<p>When working with {$topic}, keep these best practices in mind:</p>
<ul>
    <li>Follow the official documentation</li>
    <li>Write clean, maintainable code</li>
    <li>Implement proper error handling</li>
    <li>Test your code thoroughly</li>
</ul>

<h3>Conclusion</h3>
<p>Mastering {$topic} opens up new possibilities for your development projects. Continue exploring the documentation and building projects to solidify your understanding.</p>

<p><em>Happy coding!</em></p>
HTML;
    }
}

# EXPLANATION.md

## Architectural Decisions & Trade-offs

### 1. Separation of Concerns (Nuxt 4 + Laravel 11)
Instead of building a monolith (e.g., Laravel Livewire or Inertia), I opted for a decoupled architecture using **Nuxt 4** as a standalone frontend and **Laravel 11** purely as a RESTful API backend. 
- **Trade-off:** This requires running two separate servers during development and configuring CORS.
- **Why I did it:** It demonstrates modern API design and allows both the frontend and backend to scale independently, fulfilling the prompt's requirement to show full-stack API capabilities.

### 2. Database & Eager Loading
I used **SQLite** by default to make the local evaluation process as seamless as possible for the reviewer (no MySQL daemon required). However, the migrations and ORM usage are fully compatible with MySQL/PostgreSQL.
To solve the **N+1 query problem**, I utilized Laravel's `with('author')` in the `BookController` and `withCount('books')` in the `AuthorController`.

### 3. Caching Strategy
To improve performance, I wrapped the `index()` methods of both `AuthorController` and `BookController` in `Cache::remember()`.
- **Trade-off:** Caching introduces data staleness.
- **Why I did it:** To counter the staleness, I implemented cache invalidation (`Cache::flush()`) inside every state-mutating method (`store`, `update`, `destroy`). This ensures users always see fresh data while maintaining read performance.

## UI/UX Design (Neobrutalism)
The UI was intentionally designed using the **Neobrutalism** aesthetic (bold colors, hard black shadows, thick borders).
- **Why I did it:** The test requested a "clean interface." Rather than using a generic component library (like Bootstrap or standard Tailwind UI), I built a custom design system from scratch to show strong CSS/Tailwind proficiency and to make the submission stand out visually. 
- **UX Features:** Included micro-animations (buttons depressing when clicked), custom skeletons for loading states (`Skeleton.vue`), and robust client-side routing.

## Extra Features Included
1. **Automated Testing:** Added comprehensive PHPUnit Feature tests for the API and Vitest component tests for the UI.
2. **Indonesian Localization:** Localized the Faker data in Seeders to use real Indonesian names and book descriptions to make testing feel more authentic.

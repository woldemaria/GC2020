# GC Magazine Website

A modern university magazine website built with Laravel, Vue.js, and TailwindCSS.

## Features

- **Modern Design**: Clean, responsive interface inspired by university publications
- **Article Management**: Full-featured articles with categories, authors, and search
- **Photo Gallery**: Masonry-style gallery with category filtering and lightbox
- **Student Profiles**: Showcase outstanding students with achievements and interests
- **API-Driven**: RESTful API backend with Laravel
- **SPA Frontend**: Vue.js 3 with Vue Router for smooth navigation
- **Responsive Design**: Mobile-first approach with TailwindCSS

## Tech Stack

- **Backend**: Laravel 13, SQLite Database
- **Frontend**: Vue.js 3, Vue Router, TailwindCSS 4.0
- **Build Tools**: Vite, Laravel Vite Plugin
- **Fonts**: Instrument Sans via Bunny Fonts

## Pages

1. **Home**: Featured articles, quick navigation, and statistics
2. **Articles**: Browse all articles with filtering and search
3. **Article View**: Full article reading with author info and related articles
4. **Gallery**: Photo gallery with category filtering and lightbox
5. **Student Profiles**: Featured and all student profiles with filtering
6. **About**: Information about the magazine and editorial team
7. **Contact**: Contact form and office information

## API Endpoints

All endpoints are prefixed with `/api/v1/`:

- `GET /articles` - List articles with filtering
- `GET /articles/featured` - Featured articles
- `GET /articles/{slug}` - Single article
- `GET /articles/{slug}/related` - Related articles
- `GET /categories` - All categories
- `GET /photos` - Gallery photos
- `GET /student-profiles` - Student profiles

## Development

The website is built with modern web technologies and follows best practices:

- **Component-based Architecture**: Vue.js components for reusability
- **API-First Design**: Separate backend API for future mobile apps
- **SEO-Friendly**: Server-side rendering support
- **Performance Optimized**: Asset bundling and optimization with Vite

## Sample Data

The project includes comprehensive seeders with sample content:
- 6 article categories
- 4 authors (students, faculty, alumni)
- 6 sample articles with rich content
- 10 gallery photos across different categories
- 8 student profiles with achievements and interests

This creates a fully functional demonstration of a university magazine website.

## Getting Started

1. Install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

4. Build frontend assets:
   ```bash
   npm run build
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

The website will be available at http://localhost:8000
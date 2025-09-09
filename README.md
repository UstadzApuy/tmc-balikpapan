<p align="center">
    <a href="https://github.com/your-repo/tmc-balikpapan" target="_blank">
        <img src="public/images/logo/tmc.png" width="200" alt="TMC Balikpapan Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# TMC Balikpapan

TMC (Traffic Management Center) Balikpapan is a web application designed to manage and monitor traffic in the city of Balikpapan. This application provides real-time traffic updates, CCTV monitoring, and administrative tools for managing locations, users, and news.

## Features

### Public Features
- **Real-Time Traffic Monitoring**: View live traffic conditions through integrated CCTV feeds.
- **Interactive Map**: Explore traffic locations and CCTV coverage areas.
- **News and Updates**: Stay informed with the latest traffic-related news and announcements.
- **Contact Information**: Easily reach out to the Department of Transportation for inquiries or complaints.

### Admin Features
- **Dashboard**: Overview of total locations, CCTV cameras, and contacts.
- **User Management**: Add, edit, and manage system users.
- **Location Management**: Manage traffic monitoring locations and their details.
- **CCTV Management**: Add and manage CCTV cameras, including their types and statuses.
- **News Management**: Publish and manage traffic-related news.
- **Contact Management**: Manage public contact information for the Department of Transportation.

## Technologies Used

- **Backend**: Laravel 12.x (PHP 8.2)
- **Frontend**: Tailwind CSS, Alpine.js
- **Build Tools**: Vite
- **Database**: MySQL
- **Other Libraries**:
  - Leaflet.js for interactive maps
  - Video.js for video streaming
  - Font Awesome for icons

## Assets

The application uses the following assets:
- **Logo**: Located in `public/images/logo/tmc.png`.
- **Backgrounds**: Custom batik background in `public/images/bg/batik.png`.
- **Slider Images**: Available in `public/images/slider/` (e.g., `slide1.png`, `slide2.png`, `slide3.png`).
- **Icons**: Font Awesome icons for UI elements.

Ensure all assets are placed in the `public/images` directory as per the folder structure.

## Installation

Follow these steps to set up the project locally:

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL database

### Steps
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/UstadzApuy/tmc-balikpapan.git
   cd tmc-balikpapan
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials and other configurations.

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Create Sessions Table Migration** (if using database sessions):
   ```bash
   php artisan session:table
   ```

6. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

7. **Seed the Database** (optional):
   ```bash
   php artisan db:seed
   ```

8. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

9. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

10. **Run Vite for Hot Module Replacement (HMR)** (optional for development):
    ```bash
    npm run dev
    ```

## Usage

- Access the application at `http://localhost:8000` for the public interface.
- Admin panel is accessible at `http://localhost:8000/admin`.

## Folder Structure

- **`resources/views`**: Contains Blade templates for both public and admin interfaces.
- **`resources/js`**: Contains JavaScript files, including Alpine.js components.
- **`resources/css`**: Contains Tailwind CSS configuration and custom styles.
- **`routes/web.php`**: Defines application routes for public and admin sections.
- **`app/Http/Controllers`**: Contains controllers for handling application logic.

## Contribution

Contributions are welcome! Please fork the repository and create a pull request for any improvements or bug fixes.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

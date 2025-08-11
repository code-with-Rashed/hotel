# MY HOTEL

my hotel is a hotel booking web app that comes will all the necessary feature for a hotel to get their business online. it allows users to book room , give review and ratings to the hotel services.

It is a hotel booking platform. the guests can check room availability , make reservations , view detaild room information , and provide feedback through integrated review and rating systems.

It include an admin panel for booking management , room control , fund & refund management , guest review monitoring and business analytics for informed decision making.

It provides real time booking availability , automated reservation management , and detaild reporting to help hotel owners optimize their operations.

It handles complete hotel content management including room details , feature & facility information, image galleries and SSLCOMMERZ payment getway.

#### If you use this project ? then follow the bellow instructions. 

## Installation Proccess
[Download the Project ( ZIP file ) ](https://github.com/code-with-Rashed/hotel/archive/refs/heads/master.zip)

Extract the project after download completed.

##### OR
You can clone this project
```
https://github.com/code-with-Rashed/hotel.git
```

##### Open your terminal then enter to your project folder like..
```
cd hotel
```

## Let's start setup the application's backend
1. enter to the backend folder
```
cd backend
```
2. install the  dependencies
```
composer install
```
3. Copy `.env.example` to `.env`
```
cp .env.example .env
```
4. Generate application key
```
php artisan key:generate
```
5. Public storage folder
```
php artisan storage:link
```
##### Set Environment Variables
1. To open the .env file
- You can set your database information. like...
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backend
DB_USERNAME=root
DB_PASSWORD=
```
- You can set your email information. like...
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email-user-name@email.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email-address"
MAIL_FROM_NAME="${APP_NAME}"
```
2. open a sslcommerze payment getway account. then get your sslcommerze creadentials
- You can set your sslcommerze ( payment getway service ) information. like...
```
SSLC_SANDBOX=true # or false for live
SSLC_STORE_ID=your-sslcommerz-store-id
SSLC_STORE_PASSWORD=your-sslcommerz-store-password
SSLC_STORE_CURRENCY='BDT'
```
3.  You can need set your frontend application's exact url in the backend's .env file after setup this project's frontend. like..
```
FRONTEND_APP_URL=http://your-frontend-domain-name.com
```
4. Run Migrations
```
php artisan migrate:fresh
```
5. Run Database Seeders for default admin credential
```
php artisan db:seed --class=AdminDefaultCredential
```
This project's admin panel URL is `https://your-domain-name.com/admin`

Please note that the default admin email is `admin@gmail.com` and the default password is `12345`. You should change admin user credentials before deploying to production.

6. Start the webserver
```
php artisan serve
```
-  You can need set your backend application's exact url . like...
```
APP_URL=http://your-backend-domain-name.com
```
7. Run the laravel QUEUE after complete setup the .env file for asyncronus services.
```
php artisan queue:work
```

<hr/><hr/>

## Let's start setup the application's frontend
1. enter to the frontend folder
```sh
cd frontend
```
2. install the  dependencies
```sh
npm install
```
##### Set Environment Variables
1. To open the `.env` file
- You can need set your backend application's ( api's ) exact url. like...
```sh
VITE_API_URL=http://your-backend-api-domain-name.com
```
##### Run frontend application in development environment
```sh
npm run dev
```
##### If you need a production build? Then run this command.
```sh
npm run build
```
##### Run production build
```sh
npm run preview
```

<hr/><hr/>

#### This project's database diagram
![database-diagram](./previews/diagrams/database_diagram.png)<br><hr><br>

## Here are the project's UML diagrams
#### Here are the activity & use-case diagrams for the admin panel
![admin-activity-diagram](./previews/diagrams/admin_activity_diagram.png)<br><hr><br>
![admin-use-case-diagram](./previews/diagrams/admin_use_case_diagram.png)<br><hr><br>
#### Here are the activity & use-case diagrams for the customer panel
![customer-activity-diagram](./previews/diagrams/customer_activity_diagram.png)<br><hr><br>
![customer-use-case-diagram](./previews/diagrams/customer_use_case_diagram.png)<br><hr><br>
![file-structure](./previews/diagrams/file-structure.jpeg)
<br><hr><br>

#### Here are the project's related preview images for the customer panel
![home-page-preview-images](./previews/visitor_panel/home-page.png)<br><hr><br>
![room-page-preview-images](./previews/visitor_panel/room-page.png)<br><hr><br>
![room-details-page-preview-images](./previews/visitor_panel/room-details-page.png)<br><hr><br>
![room-booking-page-preview-images](./previews/visitor_panel/room-booking-page.png)<br><hr><br>
![payment-page-preview-images](./previews/visitor_panel/payment-page.png)<br><hr><br>
![payment-success-page-preview-images](./previews/visitor_panel/payment-success-page.png)<br><hr><br>
![login-page-preview-images](./previews/visitor_panel/login-page.jpeg)<br><hr><br>
![registration-page-preview-images](./previews/visitor_panel/registration-page.jpeg)<br><hr><br>
![facility-page-preview-images](./previews/visitor_panel/facility-page.png)<br><hr><br>
![contact-page-preview-images](./previews/visitor_panel/contact-page.png)<br><hr><br>
![about-page-preview-images](./previews/visitor_panel/about-page.png)<br><hr><br>

#### Here are the project's related preview images for the user panel
![user-profile-preview-images](./previews/user_panel/user-profile-page.png)<br><hr><br>
![booking-list-preview-images](./previews/user_panel/booking-list-page.png)<br><hr><br>
![rating-review-preview-images](./previews/user_panel/rating-review-modal.jpeg)<br><hr><br>
![booking-details-preview-images](./previews/user_panel/booking-details-modal.jpeg)<br><hr><br>
![invoice-preview-images](./previews/user_panel/invoice.jpeg)<br><hr><br>

#### Here are the project's related preview images for the admin panel
![admin-login-preview-images](./previews/admin_panel/room/admin-login-page.png)<br><hr><br>
![dashboard-preview-images](./previews/admin_panel/room/dashboard-page.png)<br><hr><br>
<!-- Room management -->
![room-management-preview-images](./previews/admin_panel/room/room-management-page.png)<br><hr><br>
![add-room-details-preview-images](./previews/admin_panel/room/add-room-details-modal.jpeg)<br><hr><br>
![edit-room-details-preview-images](./previews/admin_panel/room/edit-room-details-modal.jpeg)<br><hr><br>
![room-image-management-preview-images](./previews/admin_panel/room/room-image-management-page.png)<br><hr><br>
![room-feture-facility-management-preview-images](./previews/admin_panel/room/room-feture-facility-management-modal.jpeg)<br><hr><br>
<!-- carousel management -->
![carousel-management-preview-images](./previews/admin_panel/carousel/carousel-management.png)<br><hr><br>
![add-carousel-preview-images](./previews/admin_panel/carousel/add-carousel-image-modal.jpeg)<br><hr><br>
![update-carousel-preview-images](./previews/admin_panel/carousel/update-carousel-image-modal.jpeg)<br><hr><br>
<!-- facility & feature management -->
![facility-management-preview-images](./previews/admin_panel/facility/facility-management.png)<br><hr><br>
![add-facility-preview-images](./previews/admin_panel/facility/add-facility-modal.jpeg)<br><hr><br>
![update-facility-preview-images](./previews/admin_panel/facility/update-facility-modal.png)<br><hr><br>
![feature-management-preview-images](./previews/admin_panel/features/feature-management.png)<br><hr><br>
![add-feature-preview-images](./previews/admin_panel/features/add-feature-modal.jpeg)<br><hr><br>
![update-feature-preview-images](./previews/admin_panel/features/update-feature-modal.jpeg)<br><hr><br>
<!-- achievement management -->
![achievement-management-preview-images](./previews/admin_panel/achievement/achievement-management.png)<br><hr><br>
![add-achievement-preview-images](./previews/admin_panel/achievement/add-achievement-info-modal.jpeg)<br><hr><br>
![update-achievement-preview-images](./previews/admin_panel/achievement/update-achievement-info-modal.jpeg)<br><hr><br>
<!-- address management -->
![address-management-preview-images](./previews/admin_panel/address/address-management-page.png)<br><hr><br>
![update-address-management-preview-images](./previews/admin_panel/address/update-address-details-modal.jpeg)<br><hr><br>
<!-- admin profile management -->
![admin-profile-management-preview-images](./previews/admin_panel/admin-profile/admin-profile-management-page.png)<br><hr><br>
<!-- contact request management -->
![contact-request-management-preview-images](./previews/admin_panel/contact-request/contact-request-management.png)<br><hr><br>
![view-contact-message-preview-images](./previews/admin_panel/contact-request/view-contact-message-modal.jpeg)<br><hr><br>
<!-- rating-review management -->
![rating-review-management-preview-images](./previews/admin_panel/rating-review/rating-review-management.png)<br><hr><br>
<!-- settings management -->
![settings-management-preview-images](./previews/admin_panel/settings/settings-management.png)<br><hr><br>
<!-- team profile management -->
![team-profile-management-preview-images](./previews/admin_panel/team/team-profile-management.png)<br><hr><br>
![add-team-profile-preview-images](./previews/admin_panel/team/add-team-profile-modal.jpeg)<br><hr><br>
![update-team-profile-preview-images](./previews/admin_panel/team/update-team-profile-details-modal.jpeg)<br><hr><br>
<!-- users management -->
![users-management-preview-images](./previews/admin_panel/users/user-management.png)<br><hr><br>
![users-activity-preview-images](./previews/admin_panel/users/user-activity-modal.png)<br><hr><br>
<!-- booking management -->
![all-booking-management-preview-images](./previews/admin_panel/booking/all-booking-management.png)<br><hr><br>
![new-booking-management-preview-images](./previews/admin_panel/booking/new-booking-management.png)<br><hr><br>
![refund-booking-management-preview-images](./previews/admin_panel/booking/refund-booking-management.png)<br><hr><br>






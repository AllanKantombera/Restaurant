# Aunt Joy’s Restaurant System

Who to run this project
-import the database in the first folder(aunt_joy.sql), in your server(xampp)
-after import and extracting the projecting into your htdocs this is the link for landing page: http://localhost/aunt_joy/views/index.php
-the project has 3 dashboards(Admin, Sales, and Manager dashboard)

# Accounts Details
Admin 
admin@gmail.com



Manager

phiri@gmail.com



Sales

banda@gmail.com



Customers

canto@gmail.com


# Aunt Joy’s Restaurant System

Aunt Joy’s Restaurant Management System is a **web-based food ordering and restaurant operations platform** developed using **OOP PHP**, MySQL, Bootstrap, and JavaScript.  
The system streamlines **online ordering, sales processing, order tracking, and management reporting** for different user roles within the restaurant.

##Project Overview

The system allows customers to browse meals, place orders, and track their deliveries, while restaurant staff and management can efficiently process orders, monitor sales, and generate reports.

It is designed with **role-based access control**, ensuring that each user only accesses features relevant to their role.

##Key Features

###Customer
- Browse meals and categories
- Search meals
- Add items to cart
- Checkout with delivery address or GPS location
- View order history and order status

###Sales Dashboard
- View pending, preparing, delivered, and cancelled orders
- Update order delivery status
- Daily sales overview (orders & revenue)

###Manager Dashboard
- Monthly and daily sales reports
- Key metrics:
  - Total orders
  - Total revenue (daily & monthly)
  - Best-selling meals
- Export sales reports to **Excel** and **PDF**

###Admin Dashboard
- Manage meals and categories
- Manage staff users
- View system-wide statistics
- Monitor customers and orders

##User Roles

| Role | Role ID | Access |
|-----|--------|--------|
| Admin | 1 | Full system access |
| Sales | 2 | Order processing & delivery |
| Manager | 3 | Reports & analytics |

##System Architecture

The project follows an **MVC-like structure** using pure PHP:

- PHP (OOP, PDO)
- MySQL
- Bootstrap 5
- JavaScript (AJAX, Fetch API)
- HTML5 & CSS3
- Google Maps links (for delivery location)
- Excel export 
- PDF export


## License

This project is developed for **academic purposes** and demonstration of **web application development using pure PHP (OOP)**.
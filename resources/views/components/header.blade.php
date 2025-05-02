<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh bạ điện tử - Đại học Thủy Lợi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #005baa;
        --secondary-color: #00a8e8;
        --accent-color: #ff5722;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --text-color: #333;
        --bg-color: #f5f7fa;
        --border-color: #e9ecef;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
        background-color: var(--bg-color);
        line-height: 1.6;
    }

    /* Header Styles */
    .top-bar {
        background-color: var(--primary-color);
        color: white;
        padding: 8px 0;
        font-size: 0.9rem;
    }

    .top-bar a {
        color: white;
        text-decoration: none;
    }

    .top-bar a:hover {
        text-decoration: underline;
    }

    .navbar {
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px 0;
    }

    .navbar-brand img {
        height: 50px;
    }

    .navbar .nav-link {
        color: var(--dark-color);
        font-weight: 500;
        padding: 10px 15px;
        transition: all 0.3s;
    }

    .navbar .nav-link:hover, .navbar .nav-link.active {
        color: var(--primary-color);
    }

    .navbar .user-menu {
        background-color: var(--primary-color);
        color: white;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .navbar .user-menu:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x1080') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        text-align: center;
        margin-bottom: 50px;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero-section p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 30px;
        opacity: 0.9;
    }

    /* Hero actions */
    .hero-actions {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .hero-actions .btn {
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .hero-actions .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-outline {
        border: 2px solid;
    }

    /* Page Title & Header Styles */
    /* Page Title */
    .page-title {
        background-color: var(--primary-color);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
    }

    .page-title h1 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .page-title .breadcrumb {
        background: transparent;
        margin-bottom: 0;
        padding: 0;
    }

    .page-title .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .page-title .breadcrumb-item a:hover {
        color: white;
    }

    .page-title .breadcrumb-item.active {
        color: white;
    }

    .page-title .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Forum Page Header */
    .forum-header {
        background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x500?text=Forum') center/cover no-repeat;
        color: white;
        padding: 50px 0;
        margin-bottom: 30px;
    }

    .forum-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .forum-header p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto 20px;
        opacity: 0.9;
    }

    /* Messages Page Header */
    .messages-header {
        background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x500?text=Messages') center/cover no-repeat;
        color: white;
        padding: 40px 0;
        margin-bottom: 30px;
    }

    .messages-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .messages-header p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto 20px;
        opacity: 0.9;
    }

    /* Search Boxes */
    /* Main Search Box */
    .search-box {
        background-color: white;
        border-radius: 50px;
        padding: 12px 20px;
        max-width: 700px;
        margin: 0 auto;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .search-box select {
        border: none;
        background-color: var(--light-color);
        padding: 12px 20px;
        border-radius: 25px;
        outline: none;
        width: 150px;
        font-weight: 500;
        color: var(--dark-color);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-box input {
        flex-grow: 1;
        border: none;
        background-color: var(--light-color);
        padding: 12px 20px;
        outline: none;
        border-radius: 25px;
        font-size: 1rem;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-box button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        min-width: 140px;
    }

    .search-box button:hover {
        background-color: #e64a19;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Simple Search Box */
    .search-filter-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .search-filter-container .search-box {
        display: flex;
        align-items: center;
        background-color: var(--light-color);
        border-radius: 50px;
        padding: 5px 20px;
        margin-bottom: 20px;
        box-shadow: none;
    }

    .search-filter-container .search-box input {
        flex: 1;
        border: none;
        padding: 10px;
        outline: none;
        background-color: transparent;
        box-shadow: none;
    }

    .search-filter-container .search-box button {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        padding: 10px;
        min-width: unset;
    }

    .filter-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .filter-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-right: 5px;
    }

    .filter-select {
        padding: 8px 15px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
        background-color: white;
        color: var(--text-color);
        font-size: 0.9rem;
        min-width: 150px;
    }

    /* Breadcrumb */
    .breadcrumb-container {
        background-color: white;
        padding: 15px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .breadcrumb {
        margin-bottom: 0;
    }

    .breadcrumb .breadcrumb-item {
        font-size: 0.9rem;
    }

    .breadcrumb .breadcrumb-item.active {
        color: var(--primary-color);
        font-weight: 500;
    }

    /* Directory Section */
    .section-title {
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
        color: var(--primary-color);
        font-weight: 700;
    }

    /* .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--accent-color);
    } */

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%; /* Position at the middle */
        transform: translateX(-50%); /* Shift back by half of its width */
        width: 50px;
        height: 3px;
        background-color: var(--accent-color);
    }

    /* Centered section title variant */
    .section-title.text-center {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title.text-center h2 {
        font-weight: 700;
        color: var(--primary-color);
        display: inline-block;
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .section-title.text-center h2::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: var(--accent-color);
    }

    .section-title.text-center p {
        max-width: 700px;
        margin: 0 auto;
        color: #6c757d;
    }

    .directory-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .directory-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .directory-card .card-img {
        height: 160px;
        width: 100%;
        object-fit: cover;
    }

    .directory-card .card-header {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-align: center;
        padding: 15px;
        font-size: 1.2rem;
    }

    .directory-card .card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .directory-card .card-body p {
        color: #6c757d;
    }

    .directory-card .card-footer {
        background-color: white;
        border-top: 1px solid #f1f1f1;
        padding: 15px 20px;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.3s;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Forum Categories */
    .forum-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .forum-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .forum-card .card-header {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 15px 20px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .forum-card .category-icon {
        font-size: 1.5rem;
        margin-right: 10px;
        width: 30px;
        text-align: center;
    }

    .forum-card .topic-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f1f1f1;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .forum-card .topic-item:last-child {
        border-bottom: none;
    }

    .forum-card .topic-item:hover {
        background-color: #f8f9fa;
    }

    .forum-card .topic-icon {
        background-color: var(--primary-color);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .forum-card .topic-content {
        flex-grow: 1;
    }

    .forum-card .topic-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 5px;
        display: block;
        text-decoration: none;
    }

    .forum-card .topic-info {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .forum-card .topic-stats {
        display: flex;
        align-items: center;
        margin-left: 15px;
        flex-shrink: 0;
    }

    .forum-card .stat-item {
        margin-left: 15px;
        text-align: center;
    }

    .forum-card .stat-count {
        font-weight: 600;
        color: var(--primary-color);
    }

    .forum-card .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Statistics Section */
    .stats-section {
        background-color: var(--primary-color);
        color: white;
        padding: 80px 0;
        margin: 80px 0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-item .icon {
        font-size: 3rem;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-item .count {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-item .title {
        font-size: 1.2rem;
        opacity: 0.8;
    }

    /* Latest Posts */
    .latest-posts {
        margin-bottom: 40px;
    }

    .post-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .post-header {
        padding: 15px 20px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
    }

    .post-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .post-author {
        font-weight: 600;
        margin-bottom: 0;
    }

    .post-time {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .post-body {
        padding: 20px;
    }

    .post-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .post-text {
        color: #555;
        margin-bottom: 15px;
    }

    .post-footer {
        padding: 10px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .post-actions a {
        color: #6c757d;
        margin-right: 15px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .post-actions a:hover {
        color: var(--primary-color);
    }

    .post-actions i {
        margin-right: 5px;
    }

    .post-meta {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Announcement Styles */
    /* Simple Announcement Card */
    .announcement-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Simple Style */
    .announcement-card .card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .announcement-card .date {
        background-color: var(--accent-color);
        color: white;
        width: 50px;
        height: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border-radius: 5px;
        float: left;
        margin-right: 15px;
    }

    .announcement-card .date .day {
        font-size: 1.5rem;
        line-height: 1;
    }

    .announcement-card .date .month {
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .announcement-card h5 {
        font-weight: 600;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .announcement-card p {
        color: #6c757d;
        margin-bottom: 15px;
    }

    .announcement-card .meta {
        font-size: 0.85rem;
        color: #adb5bd;
    }

    /* Modern Announcement Card */
    .announcement-header {
        position: relative;
        overflow: hidden;
    }

    .announcement-header img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: all 0.3s;
    }

    .announcement-card:hover .announcement-header img {
        transform: scale(1.05);
    }

    .announcement-category {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--accent-color);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
    }

    .announcement-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .announcement-date {
        color: var(--primary-color);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .announcement-date i {
        margin-right: 8px;
    }

    .announcement-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark-color);
    }

    .announcement-title a {
        color: var(--dark-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .announcement-title a:hover {
        color: var(--primary-color);
    }

    .announcement-excerpt {
        color: #6c757d;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .announcement-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .announcement-author {
        display: flex;
        align-items: center;
    }

    .announcement-author img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }

    .announcement-author span {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .read-more i {
        margin-left: 5px;
        transition: all 0.3s;
    }

    .read-more:hover {
        color: var(--secondary-color);
    }

    .read-more:hover i {
        transform: translateX(3px);
    }

    /* Featured Announcement */
    .featured-announcement {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        position: relative;
    }

    .featured-announcement-badge {
        position: absolute;
        top: 20px;
        left: 0;
        background-color: var(--accent-color);
        color: white;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        z-index: 2;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .featured-announcement-image {
        height: 400px;
        position: relative;
        overflow: hidden;
    }

    .featured-announcement-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s;
    }

    .featured-announcement:hover .featured-announcement-image img {
        transform: scale(1.05);
    }

    .featured-announcement-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
    }

    .featured-announcement-date {
        display: inline-block;
        margin-bottom: 10px;
        font-size: 0.9rem;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 5px 15px;
        border-radius: 20px;
    }

    .featured-announcement-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .featured-announcement-title a {
        color: white;
        text-decoration: none;
    }

    .featured-announcement-excerpt {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
    }

    .featured-announcement-button {
        display: inline-block;
        background-color: var(--accent-color);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .featured-announcement-button:hover {
        background-color: white;
        color: var(--accent-color);
        transform: translateY(-2px);
    }

    /* Sidebar Styles */
    /* Forum Sidebar */
    .forum-sidebar .card {
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .forum-sidebar .card-header {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 15px 20px;
    }

    .forum-sidebar .list-group-item {
        padding: 12px 20px;
        border-color: #f1f1f1;
        transition: all 0.3s;
    }

    .forum-sidebar .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .forum-sidebar .list-group-item i {
        color: var(--primary-color);
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .forum-sidebar .badge {
        background-color: var(--accent-color);
        font-weight: 500;
    }

    .forum-sidebar .user-item {
        display: flex;
        align-items: center;
    }

    .forum-sidebar .user-item img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .forum-sidebar .card-footer {
        background-color: white;
        border-top: 1px solid #f1f1f1;
        padding: 12px 20px;
        text-align: center;
    }

    .forum-sidebar .btn-sm {
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* General Sidebar */
    .sidebar-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
    }

    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .categories-list li {
        margin-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }

    .categories-list li:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .categories-list a {
        color: var(--text-color);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
    }

    .categories-list a:hover {
        color: var(--primary-color);
        padding-left: 5px;
    }

    .categories-list .badge {
        background-color: var(--primary-color);
        color: white;
        font-weight: 500;
        border-radius: 20px;
        padding: 5px 10px;
    }

    .recent-posts {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-post-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .recent-post-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .recent-post-image {
        width: 70px;
        height: 70px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 15px;
    }

    .recent-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-post-content h5 {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .recent-post-content h5 a {
        color: var(--dark-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .recent-post-content h5 a:hover {
        color: var(--primary-color);
    }

    .recent-post-date {
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Subscribe Form */
    .subscribe-form {
        display: flex;
        margin-top: 15px;
    }

    .subscribe-form input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: 25px 0 0 25px;
        outline: none;
    }

    .subscribe-form button {
        padding: 10px 20px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 0 25px 25px 0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .subscribe-form button:hover {
        background-color: var(--secondary-color);
    }

    /* New Topic Button */
    .new-topic-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--accent-color);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        z-index: 1000;
    }

    .new-topic-btn:hover {
        transform: translateY(-5px) rotate(90deg);
        background-color: #e64a19;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        color: white;
    }

    /* New Message Button */
    .new-message-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--accent-color);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        z-index: 1000;
        text-decoration: none;
    }

    .new-message-btn:hover {
        transform: translateY(-5px);
        background-color: #e64a19;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        color: white;
    }

    /* Pagination Styles */
    /* Bootstrap Pagination */
    .pagination {
        margin-top: 20px;
        margin-bottom: 40px;
        justify-content: center;
    }

    .pagination .page-item .page-link {
        color: var(--primary-color);
        transition: all 0.3s;
        border-radius: 5px;
        margin: 0 3px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }

    /* Custom Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .pagination-container .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-container .pagination li {
        margin: 0 5px;
    }

    .pagination-container .pagination a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination-container .pagination a:hover,
    .pagination-container .pagination a.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Dropdown Menu */
    .dropdown-menu {
        min-width: 220px;
        padding: 0;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
    }

    .dropdown-header {
        background-color: var(--primary-color);
        color: white;
        padding: 15px;
        font-weight: 600;
    }

    .dropdown-item {
        padding: 12px 15px;
        transition: all 0.3s;
    }

    .dropdown-item:hover {
        background-color: var(--light-color);
        padding-left: 20px;
    }

    .dropdown-item i {
        width: 25px;
        color: var(--primary-color);
    }

    .dropdown-divider {
        margin: 0;
    }

    /* User Profile Info */
    .user-info-modal .modal-header {
        background-color: var(--primary-color);
        color: white;
    }

    .user-info-modal .avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto 20px;
        display: block;
    }

    .user-info-modal .user-details {
        text-align: center;
        margin-bottom: 20px;
    }

    .user-info-modal .user-details h4 {
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .user-info-modal .user-details .badge {
        background-color: var(--primary-color);
        font-size: 0.8rem;
        padding: 5px 10px;
    }

    .user-info-modal .info-list {
        list-style: none;
        padding: 0;
    }

    .user-info-modal .info-list li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .user-info-modal .info-list li:last-child {
        border-bottom: none;
    }

    .user-info-modal .info-list i {
        color: var(--primary-color);
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }

    /* Messages Container */
    .messages-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
        height: calc(100vh - 300px);
        min-height: 500px;
        display: flex;
    }

    /* Contacts List */
    .contacts-list {
        width: 300px;
        border-right: 1px solid #eee;
        overflow-y: auto;
        height: 100%;
    }

    .contacts-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        background-color: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .search-contact {
        position: relative;
    }

    .search-contact input {
        padding-left: 35px;
        border-radius: 20px;
        border: 1px solid #ddd;
    }

    .search-contact i {
        position: absolute;
        left: 12px;
        top: 12px;
        color: #777;
    }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f1f1f1;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .contact-item:hover {
        background-color: #f5f7fa;
    }

    .contact-item.active {
        background-color: #e6f3ff;
        border-left: 3px solid var(--primary-color);
    }

    .contact-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }

    .contact-info {
        flex-grow: 1;
        overflow: hidden;
    }

    .contact-name {
        font-weight: 600;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .contact-preview {
        font-size: 0.85rem;
        color: #777;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .contact-meta {
        text-align: right;
        min-width: 55px;
    }

    .contact-time {
        font-size: 0.75rem;
        color: #999;
        margin-bottom: 5px;
    }

    .contact-badge {
        display: inline-block;
        background-color: var(--accent-color);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        text-align: center;
        line-height: 18px;
    }

    .contact-status {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .status-online {
        background-color: #4CAF50;
    }

    .status-offline {
        background-color: #9e9e9e;
    }

    .status-away {
        background-color: #FFC107;
    }

    /* Chat Area */
    .chat-area {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chat-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-user {
        display: flex;
        align-items: center;
    }

    .chat-user img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }

    .chat-user-info h5 {
        margin-bottom: 0;
        font-weight: 600;
    }

    .chat-user-info p {
        margin-bottom: 0;
        font-size: 0.85rem;
        color: #777;
    }

    .chat-actions a {
        color: var(--primary-color);
        font-size: 1.1rem;
        margin-left: 15px;
        text-decoration: none;
        transition: color 0.2s;
    }

    .chat-actions a:hover {
        color: var(--secondary-color);
    }

    .chat-messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
        background-color: #f5f7fa;
    }

    .message {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .message.outgoing {
        align-items: flex-end;
    }

    .message.incoming {
        align-items: flex-start;
    }

    .message-content {
        max-width: 75%;
        padding: 12px 15px;
        border-radius: 18px;
        margin-bottom: 5px;
        position: relative;
    }

    .message.outgoing .message-content {
        background-color: var(--primary-color);
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message.incoming .message-content {
        background-color: white;
        border-bottom-left-radius: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .message-time {
        font-size: 0.75rem;
        color: #999;
        margin-top: 3px;
    }

    .chat-input {
        padding: 15px;
        border-top: 1px solid #eee;
        background-color: white;
        display: flex;
        align-items: center;
    }

    .chat-input textarea {
        flex-grow: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 10px 15px;
        resize: none;
        outline: none;
        max-height: 100px;
    }

    .chat-input button {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        margin-left: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .chat-input button:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .chat-input .attachment-btn {
        background-color: transparent;
        color: #777;
        margin-right: 10px;
        width: 34px;
        height: 34px;
    }

    .chat-input .attachment-btn:hover {
        color: var(--primary-color);
        background-color: #f1f1f1;
        transform: none;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 20px;
        text-align: center;
        color: #777;
    }

    .empty-state i {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        margin-bottom: 10px;
        color: #555;
    }

    .empty-state p {
        max-width: 300px;
        margin-bottom: 20px;
    }

    /* Date Divider */
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .date-divider span {
        background-color: #f5f7fa;
        padding: 0 15px;
        font-size: 0.85rem;
        color: #777;
        position: relative;
        z-index: 1;
    }

    .date-divider:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #ddd;
        z-index: 0;
    }

    /* Message with Image */
    .message-with-image .message-content {
        padding-bottom: 0;
        overflow: hidden;
    }

    .message-image {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .message-image:hover {
        opacity: 0.9;
    }

    /* Footer */
    footer {
        background-color: var(--dark-color);
        color: white;
        padding: 70px 0 0;
        margin-top: 50px;
    }

    .footer-about img {
        width: 200px;
        margin-bottom: 20px;
    }

    .footer-about p {
        opacity: 0.8;
        margin-bottom: 20px;
    }

    .footer-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 30px;
        height: 2px;
        background-color: var(--accent-color);
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s;
    }

    .footer-links a:hover {
        color: white;
        padding-left: 5px;
    }

    .footer-contact i {
        width: 30px;
        color: var(--accent-color);
    }

    .footer-bottom {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 20px 0;
        margin-top: 50px;
        text-align: center;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .social-icons {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 10px;
    }

    .social-icons li a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .social-icons li a:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
    }

    /* Teacher List */
    .teacher-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .teacher-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .teacher-count {
            font-weight: 600;
            color: var(--dark-color);
        }

        .view-options button {
            background-color: var(--light-color);
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            margin-left: 10px;
            color: var(--dark-color);
            cursor: pointer;
            transition: all 0.3s;
        }

        .view-options button.active, .view-options button:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .teacher-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .teacher-item:hover {
            background-color: var(--light-color);
        }

        .teacher-item:last-child {
            border-bottom: none;
        }

        .teacher-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .teacher-info {
            flex: 1;
        }

        .teacher-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .teacher-position {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .teacher-department {
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .teacher-department a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .teacher-department a:hover {
            text-decoration: underline;
        }

        .teacher-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: var(--primary-color);
            transition: all 0.3s;
            text-decoration: none;
        }

        .action-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        
        /* Modal styles */
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 30px;
        }

        .teacher-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .teacher-detail-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .teacher-detail-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            text-align: center;
        }

        .teacher-detail-position {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .teacher-detail-info {
            width: 100%;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .teacher-detail-info li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .teacher-detail-info li:last-child {
            border-bottom: none;
        }

        .teacher-detail-info i {
            color: var(--primary-color);
            width: 30px;
            font-size: 1.1rem;
        }

        .detail-label {
            font-weight: 600;
            width: 120px;
            color: var(--dark-color);
        }

        .detail-value {
            flex: 1;
        }

        .detail-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .detail-value a:hover {
            text-decoration: underline;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 30px 30px;
        }

        /* Access Denied */
        .access-denied {
            background-color: white;
            border-radius: 10px;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 30px 0;
        }

        .access-denied i {
            font-size: 5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .access-denied h2 {
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .access-denied p {
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto 20px;
        }

        /* Student List */
        .student-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .student-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .student-count {
            font-weight: 600;
            color: var(--dark-color);
        }


        .student-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .student-item:hover {
            background-color: var(--light-color);
        }

        .student-item:last-child {
            border-bottom: none;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .student-info {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .student-id {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .student-class {
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .student-class a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .student-class a:hover {
            text-decoration: underline;
        }

        .student-actions {
            display: flex;
            gap: 10px;
        }

        /* Grid View */
        .student-list.grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .student-list.grid-view .student-item {
            flex-direction: column;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
        }

        .student-list.grid-view .student-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .student-list.grid-view .student-actions {
            margin-top: 15px;
        }


        .student-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .student-detail-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .student-detail-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            text-align: center;
        }

        .student-detail-id {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .student-detail-info {
            width: 100%;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .student-detail-info li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .student-detail-info li:last-child {
            border-bottom: none;
        }

        .student-detail-info i {
            color: var(--primary-color);
            width: 30px;
            font-size: 1.1rem;
        }

        /* Access Restricted */
        .access-restricted {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 30px 0;
        }

        .access-restricted i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .access-restricted h3 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .access-restricted p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        /* Unit Card Styles */
        .unit-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .unit-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .unit-count {
            font-weight: 600;
            color: var(--dark-color);
        }

        
        /* Unit List View */
        .unit-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .unit-item:hover {
            background-color: var(--light-color);
        }

        .unit-item:last-child {
            border-bottom: none;
        }

        .unit-logo {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 20px;
            border: 1px solid var(--border-color);
            padding: 5px;
            background-color: white;
        }

        .unit-info {
            flex: 1;
        }

        .unit-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .unit-type {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .unit-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: var(--dark-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .unit-meta-item {
            display: flex;
            align-items: center;
        }

        .unit-meta-item i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .unit-actions {
            display: flex;
            gap: 10px;
            align-self: center;
        }

        /* Grid View */
        .unit-list.grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .unit-list.grid-view .unit-item {
            flex-direction: column;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }

        .unit-list.grid-view .unit-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .unit-list.grid-view .unit-info {
            text-align: center;
        }

        .unit-list.grid-view .unit-meta {
            justify-content: center;
        }

        .unit-list.grid-view .unit-actions {
            margin-top: 15px;
            justify-content: center;
        }

        .unit-detail {
            display: flex;
            flex-direction: column;
        }

        .unit-detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .unit-detail-logo {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 30px;
            border: 3px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 5px;
            background-color: white;
        }

        .unit-detail-title {
            flex: 1;
        }

        .unit-detail-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .unit-detail-type {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .unit-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.95rem;
        }

        .unit-detail-meta-item {
            display: flex;
            align-items: center;
        }

        .unit-detail-meta-item i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .unit-detail-info {
            margin-bottom: 30px;
        }

        .unit-detail-section {
            margin-bottom: 25px;
        }

        .unit-detail-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .unit-detail-description {
            margin-bottom: 20px;
            text-align: justify;
        }

        .leader-list, .staff-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 15px;
        }

        .leader-item, .staff-item {
            display: flex;
            align-items: center;
            width: calc(50% - 10px);
            padding: 10px;
            border-radius: 5px;
            background-color: var(--light-color);
        }

        .leader-avatar, .staff-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid white;
        }

        .leader-info, .staff-info {
            flex: 1;
        }

        .leader-name, .staff-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
        }

        .leader-position, .staff-position {
            font-size: 0.9rem;
            color: var(--accent-color);
        }

        .contact-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-info-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .contact-info-item:last-child {
            border-bottom: none;
        }

        .contact-info-item i {
            color: var(--primary-color);
            width: 30px;
            font-size: 1.1rem;
        }

        .contact-label {
            font-weight: 600;
            width: 120px;
            color: var(--dark-color);
        }

        .contact-value {
            flex: 1;
        }

        .contact-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .contact-value a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .student-list.grid-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .unit-list.grid-view {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
            .leader-item, .staff-item {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .filter-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                width: 100%;
                margin-bottom: 10px;
            }

            .filter-select {
                width: 100%;
            }

            .teacher-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .teacher-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .teacher-actions {
                margin-top: 15px;
            }

            .unit-item {
                flex-direction: column;
            }

            .unit-logo {
                margin: 0 0 15px 0;
            }

            .unit-detail-header {
                flex-direction: column;
                text-align: center;
            }

            .unit-detail-logo {
                margin: 0 0 15px 0;
            }

            .unit-detail-meta {
                justify-content: center;
            }
        }

    /* Responsive */
    @media (max-width: 992px) {
        .stat-item {
            display: none;
        }

        .forum-card .topic-stats {
            display: none;
        }

        .hero-section {
            padding: 80px 0;
        }

        .hero-section h1 {
            font-size: 2.5rem;
        }

        .search-box {
            flex-direction: column;
            border-radius: 10px;
            padding: 15px;
        }

        .search-box select,
        .search-box input,
        .search-box button {
            width: 100%;
            margin-bottom: 10px;
        }

        .messages-container {
            height: calc(100vh - 250px);
        }

        .featured-announcement-image {
            height: 300px;
        }

        .featured-announcement-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .student-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .student-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .student-actions {
                margin-top: 15px;
            }

            .student-list.grid-view {
                grid-template-columns: 1fr;
            }
        .forum-header {
            padding: 40px 0;
        }

        .forum-header h1 {
            font-size: 2rem;
        }

        .post-card {
            margin-bottom: 15px;
        }

        .hero-section {
            padding: 60px 0;
        }

        .hero-section h1 {
            font-size: 2rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .stat-item {
            margin-bottom: 30px;
        }

        .contacts-list {
            width: 75px;
            border-right: 1px solid #eee;
        }

        .contact-info, .contact-meta {
            display: none;
        }

        .contact-item {
            padding: 10px;
            display: flex;
            justify-content: center;
        }

        .contact-avatar {
            margin-right: 0;
        }

        .contacts-header {
            display: none;
        }

        .chat-header {
            padding: 10px;
        }

        .featured-announcement-image {
            height: 250px;
        }

        .filter-options {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-group {
            width: 100%;
            margin-bottom: 10px;
        }

        .filter-select {
            width: 100%;
        }
    }



    @media (max-width: 576px) {
        .top-bar {
            display: none;
        }

        .page-title h1 {
                font-size: 1.8rem;
            }

            .student-list-header {
                flex-direction: column;
                gap: 10px;
            }

            .view-options {
                align-self: flex-end;
            }
            .unit-list-header {
                flex-direction: column;
                gap: 10px;
            }
        .post-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .post-meta {
            margin-top: 10px;
        }

        .messages-header {
            padding: 30px 0;
        }

        .messages-header h1 {
            font-size: 1.8rem;
        }

        .messages-container {
            height: calc(100vh - 220px);
        }

        .featured-announcement-badge {
            font-size: 0.8rem;
            padding: 5px 15px;
        }

        .featured-announcement-overlay {
            padding: 20px;
        }

        .featured-announcement-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .featured-announcement-excerpt {
            display: none;
        }

        .announcement-card {
            margin-bottom: 20px;
        }

        .announcement-header img {
            height: 160px;
        }

    }

    </style>
</head>

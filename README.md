# 📰 Digital Newspaper Management System (Laravel)

A full-featured **Digital Newspaper Management System** built with **PHP Laravel, Bootstrap, CSS, JavaScript, and jQuery**. This system is designed to manage online news publishing, editorial workflow, advertisements, user engagement, and real-time content delivery for a modern news portal.

---

## 🚀 Key Features

### 📰 Article & News Management
- Create, edit, publish, and archive articles
- Article categorization and topic tagging
- Multiple authors support
- Article photos and media management
- Breaking news system
- Trending and popular articles tracking
- Today's paper scheduling system

### 👥 User & Author System
- Admin, editors, and authors management
- Customer registration & subscription system
- Author profiles and article assignment
- Authentication logs tracking

### 📊 Editorial & Content Control
- Article moderation system (MIS workflow)
- Draft, review, publish lifecycle
- Department-based content control
- Live updates and incident reporting

### 📢 Advertisement System
- Advertisement order management
- Ad placement control across pages
- Marketing companies & persons database
- Revenue tracking from ads

### 🗳️ Engagement Modules
- Polls and voting system
- Popular articles ranking system
- Customer subscribed news feeds
- Social sharing (Facebook stickers integration)

### 🌍 Regional & Event Coverage
- Events management
- Election results & statistical figures
- Incident reporting system
- Location-based news categorization

### ⚙️ Settings & Configuration
- General settings management
- Meta tags & SEO configuration
- Social media integration settings
- Page management system
- Important links & categories
- Ramadan timing module

---

## 🧱 Tech Stack

- **Backend:** PHP Laravel
- **Frontend:** Bootstrap, CSS, JavaScript, jQuery
- **Database:** MySQL
- **Architecture:** MVC Pattern (Laravel)
- **Authentication:** Laravel Auth system
- **UI Type:** Admin panel + news portal frontend

---

## 📂 Database Overview

### 📰 Content Core
articles, article_details, article_photos, article_topics, article_categories, articles_mis, article_authors

### 👥 Users & Auth
users, authors, customers, auth_logs, password_resets

### 📢 Ads & Marketing
advertisement_orders, advertisement_placements, marketing_companies, marketing_persons

### 📊 News Features
breakings, trending_topics, popular_articles, live_updates, archived_topics

### 🗳️ Elections & Reports
election_results, election_result_figures, reports_articlehit

### 🌍 Events & Locations
events, incidents, locations

### ⚙️ System Settings
settings_general, settings_meta, settings_pages, settings_social

### 📬 Other Modules
customer_subscribed_news, polls, important_links, important_link_categories, ramadan_timings, facebook_stickers, departments

---

## ⚙️ Installation Guide

```bash
git clone https://github.com/your-username/digital-newspaper-system.git
cd digital-newspaper-system
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
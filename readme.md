Laravel project to show multi-tenancy function with ability to assign one user to more than one team.

It is an extended version of module "Teams multi-tenancy" from our [QuickAdminPanel Laravel generator](https://quickadminpanel.com).

## Screenshots

__List of teams__

![Laravel Multi-tenancy screenshot 01](https://laraveldaily.com/wp-content/uploads/2018/11/tenancy-demo-01-teams.png)

---

__Assigning user to more than one team__

![Laravel Multi-tenancy screenshot 02](https://laraveldaily.com/wp-content/uploads/2018/11/tenancy-demo-02-multi-teams.png)

---

__If you belong to multiple teams, choose the one to log in to__

![Laravel Multi-tenancy screenshot 03](https://laraveldaily.com/wp-content/uploads/2018/11/tenancy-demo-03-choose-team.png)

---

__CRUD with showing the user/team and ability to change team (top-right)__

![Laravel Multi-tenancy screenshot 04](https://laraveldaily.com/wp-content/uploads/2018/11/tenancy-demo-04-products.png)

---


## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL and login with default credentials __admin@admin.com__ - __password__

## License

Basically, feel free to use and re-use any way you want.

---

## More from our LaravelDaily Team

- Check out our adminpanel generator [QuickAdminPanel](https://quickadminpanel.com) 
- Read our [Blog with Laravel Tutorials](https://laraveldaily.com)
- Subscribe to our [newsletter with 20+ Laravel links every Thursday](http://laraveldaily.com/weekly-laravel-newsletter/)
- Subscribe to our [YouTube channel Laravel Business](https://www.youtube.com/channel/UCTuplgOBi6tJIlesIboymGA)
- Enroll in our [Laravel Online Courses](https://laraveldaily.teachable.com/)

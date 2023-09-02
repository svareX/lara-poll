
# Lara-Poll

## About the project 
Lara-Poll is a web application that combined many of my previous' projects into one. After registration & logging in you can browse currently ongoing polls in real-time, vote, create your own polls and even receive real-time notifications when polls finish. The polling data of each poll is also updated in real-time. The whole project it glued together using Laravel and front-end is created with VueJS. The application supports both dark and light mode depending on user's browser settings.

## Technologies used to accomplish this solution are:

 - [Laravel](https://laravel.com/)
 - [Vue3](https://vuejs.org/)
 - [InertiaJS](https://inertiajs.com/)
 - [TailwindCSS](https://tailwindcss.com/)
 
## Try it yourself!
First you need to clone the repository.

    git clone https://github.com/svareX/lara-poll

Then install all the package and dependencies.

    composer install

After that you need to setup an .env file (use the .env.example as a template)

    copy .env.example .env



Generate a new application key

    php artisan key:generate
 
 Install front-end packages

    npm install

 Compile front-end assets in real-time

    npm run dev
       
**Now, you must leave this terminal window running and open a new one!**
<p>Create your database table.</p>

    php artisan migrate


While you have a local database server like [XAMPP](https://www.apachefriends.org/)
Then all you need to do is to start a local Laravel server.

    php artisan serve
 **Now, you must leave this terminal window running and open a new one!**
<p>Start the scheduler.</p>

    php artisan schedule:work


## Image gallery

<p align="center">
<img src="https://i.ibb.co/BsmG0T7/Fire-Shot-Capture-020-Ongoing-polls-localhost.png" alt="Fire-Shot-Capture-020-Ongoing-polls-localhost">
</p>


<p align="center">
<img src="https://i.ibb.co/GWCYkP4/Fire-Shot-Capture-023-Test-User-s-polls-localhost.png" alt="Fire-Shot-Capture-023-Test-User-s-polls-localhost">
</p>

<p align="center">
<img src="https://i.ibb.co/cb2z2CX/Fire-Shot-Capture-024-Viewing-poll-Whos-the-best-localhost.png" alt="Fire-Shot-Capture-024-Viewing-poll-Whos-the-best-localhost" border="0"></a>
</p>

<p align="center">
<img src="https://i.ibb.co/prjLPQP/Fire-Shot-Capture-025-Create-a-new-poll-localhost.png" alt="Fire-Shot-Capture-025-Create-a-new-poll-localhost">
</p>

## License
MIT License

Copyright (c) [2023]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

# Setup instructions

Here are some instructions for running the application. 

1. `mkdir game-app`
2. `cd game-app`
3. `git clone https://github.com/mixtapeco/e-game-deck.git .`
4. `composer install`
5. Setup database: 
    1. `mysql -u root`
    2. `create database game-deck;` 
    3. `exit`
6. Setup env
    1. `cp .env.example .env`
    2. edit .env to have db `game-deck`
7. `php artisan migrate`
8. **`npm install`**
9. **`npm run dev`**
10. `php artisan serve`
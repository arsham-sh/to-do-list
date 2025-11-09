# to-do-list

## Installation & Setup Instructions

Follow these steps to install and set up the project:

1.  **Clone the repository**

    ```bash
    git clone git@github.com:arsham-sh/to-do-list.git
    cd to-do-list
    ```
2.  **Install dependencies:**

    ```bash
    composer install
    composer update
    ```
3.  **Copy the example environment file and make the required configuration adjustments:**

    ```bash
    cp .env.example .env
    ```
4.  **migrate the database:**

    ```bash
    php artisan migrate
    ```
5.  **enjoy your code:**

    ```bash
    php artisan serve
    ```

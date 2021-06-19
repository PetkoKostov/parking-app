## Installation

```bash
sudo docker-compose build app

sudo docker-compose up -d

sudo  docker-compose exec app composer install

sudo  docker-compose exec app php artisan key:generate

sudo  docker-compose exec app php artisan migrate
```
N.B.
If using tool like PostMan do not forget to set
![alt text](https://i.stack.imgur.com/n2eBy.png)

## Usage
POST /api/vehicle-enter

```json
{
    "category": "B",
    "reg_num": "CB1237KK",
    "promo_card": "Silver" // optional
}
```

GET /api/check-bill
```json
{
    "reg_num": "CB1237KK"
}
```

POST /api/vehicle-leave
```json
{
    "reg_num": "CB1237KK"
}
```

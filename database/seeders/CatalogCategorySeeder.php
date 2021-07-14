<?php

namespace Database\Seeders;

use App\Models\Admin\CatalogCategory;
use Illuminate\Database\Seeder;

class CatalogCategorySeeder extends Seeder
{
    /**
     * @var CatalogCategory
     */
    private $category;

    public function __construct(CatalogCategory $category)
    {
        $this->category = $category;

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeCategory($this->categories());

    }

    public function makeCategory(array $categories, $parentId = null)
    {
        info(config('app.faker_locale'));
        $faker = \Faker\Factory::create(config('app.faker_locale'));

        foreach ($categories as $category) {
            $parent = $this->category::create([
                'parent_id'        => $parentId,
                'title'            => $category['title'],
                'description'      => $faker->paragraph,
                'meta_title'       => $faker->title,
                'meta_description' => $faker->text,
                'meta_keyword'     => implode(', ', $faker->words),
            ]);

            if ( ! empty($category['children'])) {
                $this->makeCategory($category['children'], $parent['id']);
            }
        }
    }

    private function categories(): array
    {
        return [
            [
                'title'    => 'По Возрасту',
                'children' => [
                    [
                        'title' => '1 > 12 месяца',
                    ],
                    [
                        'title' => '12 > 24 месяца',
                    ],
                    [
                        'title' => '2 > 3 года',
                    ],
                    [
                        'title' => '4 > 6 лет',
                    ],
                    [
                        'title' => '7 > 9 лет',
                    ],
                    [
                        'title' => '10+ лет',
                    ],
                ]
            ],

            [
                'title'    => 'Имитационные игры',
                'children' => [
                    [
                        'title' => 'Фигурки и коллекционные открытки',
                    ],
                    [
                        'title' => 'Воображаемые миры'
                    ],
                    [
                        'title' => 'Как взрослые'
                    ],
                    [
                        'title' => 'Кухня и столовая'
                    ],
                    [
                        'title' => 'DIY - садоводство'
                    ],
                ],

            ],
            [
                'title'    => 'Спорт и игры на открытом воздухе',
                'children' => [
                    [
                        'title' => 'Аксессуары для спорта и фитнеса',
                    ],
                    [
                        'title' => 'Мячи и насосы'
                    ],
                    [
                        'title' => 'Плавание'
                    ],
                    [
                        'title' => 'Роликовые коньки, скейтборды и самокаты'
                    ],
                    [
                        'title' => 'Тренажеры'
                    ],
                ],

            ],
            [
                'title'    => 'Радиоуправляемые автомобили, схемы и игрушки',
                'children' => [
                    [
                        'title' => 'Квадрокоптеры',
                    ],
                    [
                        'title' => 'Радиоуправляемые машинки'
                    ],
                    [
                        'title' => 'Катера и Яхты'
                    ],
                    [
                        'title' => 'Радиоуправляемые вертолеты'
                    ],
                    [
                        'title' => 'Самолеты'
                    ],
                ],

            ],
            [
                'title'    => 'Куклы и мягкие игрушки',
                'children' => [
                    [
                        'title' => 'Трендовые куклы',
                    ],
                    [
                        'title' => 'Домики и мебель для кукол'
                    ],
                    [
                        'title' => 'Аксессуары для кукол'
                    ],
                    [
                        'title' => 'Пупсы и куклы стандартные'
                    ],
                    [
                        'title' => 'Аналоги Барби'
                    ],
                ],

            ],
            [
                'title'    => 'Настольные игры',
                'children' => [
                    [
                        'title' => 'Вечериночные',
                    ],
                    [
                        'title' => ' Карточные'
                    ],
                    [
                        'title' => ' Кооперативные'
                    ],
                    [
                        'title' => 'Логические'
                    ],
                    [
                        'title' => 'Приключенческие'
                    ],
                    [
                        'title' => 'Экономические'
                    ],
                    [
                        'title' => 'Стратегические'
                    ],
                ],

            ]
        ];
    }
}

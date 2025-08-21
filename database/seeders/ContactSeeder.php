<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Telepon',
                'value' => '+62542876291',
                'type' => 'phone',
                'icon' => 'phone',
                'url' => 'tel:+62542876291',
                'order' => 1
            ],
            [
                'name' => 'Telp. Kadishub',
                'value' => '+6281934558008',
                'type' => 'phone',
                'icon' => 'phone',
                'url' => 'tel:+6281934558008',
                'order' => 2
            ],
            [
                'name' => 'Email',
                'value' => 'dishubbalikpapan@gmail.com',
                'type' => 'email',
                'icon' => 'email',
                'url' => 'mailto:dishubbalikpapan@gmail.com',
                'order' => 3
            ],
            [
                'name' => 'X (Twitter)',
                'value' => 'dishub_bpn',
                'type' => 'social',
                'icon' => 'twitter',
                'url' => 'https://twitter.com/dishub_bpn',
                'order' => 4
            ],
            [
                'name' => 'Facebook',
                'value' => 'Dishubbalikpapan',
                'type' => 'social',
                'icon' => 'facebook',
                'url' => 'https://www.facebook.com/Dishubbalikpapan',
                'order' => 5
            ],
            [
                'name' => 'Instagram',
                'value' => 'dishub.balikpapan',
                'type' => 'social',
                'icon' => 'instagram',
                'url' => 'https://www.instagram.com/dishub.balikpapan',
                'order' => 6
            ],
            [
                'name' => 'Derek 1',
                'value' => '+6282153311060',
                'type' => 'phone',
                'icon' => 'phone',
                'url' => 'tel:+6282153311060',
                'order' => 7
            ],
            [
                'name' => 'Derek 2',
                'value' => '+628115428138',
                'type' => 'phone',
                'icon' => 'phone',
                'url' => 'tel:+628115428138',
                'order' => 8
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}

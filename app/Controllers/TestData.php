<?php

namespace App\Controllers;

class TestData extends BaseController
{
    public function create()
    {
        $foundItemModel = new \App\Models\FoundItemModel();
        $claimedItemModel = new \App\Models\ClaimedItemModel();
        
        // Sample found items
        $testItems = [
            [
                'user_id' => 2, // user account
                'founder_name' => 'John Doe',
                'contact_number' => '+1234567890',
                'item_name' => 'Black Wallet',
                'description' => 'Black leather wallet found near the library. Contains cards and some cash.',
                'location' => 'Main Library - 2nd Floor',
                'status' => 'pending',
                'date_reported' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'user_id' => 2,
                'founder_name' => 'Jane Smith',
                'contact_number' => '+0987654321',
                'item_name' => 'Blue Backpack',
                'description' => 'Blue Jansport backpack with laptop inside. Found in cafeteria.',
                'location' => 'Student Cafeteria',
                'status' => 'approved',
                'date_reported' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'user_id' => 2,
                'founder_name' => 'Mike Johnson',
                'contact_number' => '+1122334455',
                'item_name' => 'iPhone 13',
                'description' => 'Space Gray iPhone 13 with cracked screen. Found in parking lot.',
                'location' => 'Parking Lot B',
                'status' => 'approved',
                'date_reported' => date('Y-m-d H:i:s', strtotime('-3 hours'))
            ],
            [
                'user_id' => 2,
                'founder_name' => 'Sarah Wilson',
                'contact_number' => '+5566778899',
                'item_name' => 'Red Umbrella',
                'description' => 'Red umbrella with wooden handle. Left at bus stop.',
                'location' => 'Bus Stop - Main Entrance',
                'status' => 'claimed',
                'date_reported' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ]
        ];
        
        // Insert test items
        foreach ($testItems as $item) {
            $foundItemModel->insert($item);
        }
        
        // Get an approved item ID for test claim
        $approvedItem = $foundItemModel->where('status', 'approved')->first();
        
        if ($approvedItem) {
            // Sample pending claim
            $testClaim = [
                'item_id' => $approvedItem['id'],
                'claimant_name' => 'Alex Thompson',
                'claimant_contact' => '+1999888777',
                'date_claimed' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'notes' => 'This is my backpack. I lost it yesterday during lunch. It has my name written inside the front pocket and contains my laptop with custom stickers.',
                'status' => 'pending'
            ];
            
            $claimedItemModel->insert($testClaim);
        }
        
        return redirect()->to('/dashboard')->with('success', 'Test data created successfully! You can now see sample items and claims in the dashboard.');
    }
    
    public function clear()
    {
        $foundItemModel = new \App\Models\FoundItemModel();
        $claimedItemModel = new \App\Models\ClaimedItemModel();
        
        // Clear test data (only items created by user ID 2)
        $foundItemModel->where('user_id', 2)->delete();
        $claimedItemModel->where('status', 'pending')->delete();
        
        return redirect()->to('/dashboard')->with('success', 'Test data cleared successfully!');
    }
}
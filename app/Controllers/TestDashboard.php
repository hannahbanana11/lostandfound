<?php

namespace App\Controllers;

class TestDashboard extends BaseController
{
    public function test()
    {
        echo "<h1>Testing Dashboard Components</h1>";
        
        try {
            echo "<h2>1. Testing FoundItemModel Statistics</h2>";
            $foundItemModel = new \App\Models\FoundItemModel();
            $statistics = $foundItemModel->getStatistics();
            echo "<pre>"; print_r($statistics); echo "</pre>";
            
            echo "<h2>2. Testing Pending Items</h2>";
            $pendingItems = $foundItemModel->getFoundItemsWithUser('pending');
            echo "Count: " . count($pendingItems) . "<br>";
            echo "<pre>"; print_r($pendingItems); echo "</pre>";
            
            echo "<h2>3. Testing Approved Items</h2>";
            $approvedItems = $foundItemModel->getFoundItemsWithUser('approved');
            echo "Count: " . count($approvedItems) . "<br>";
            echo "<pre>"; print_r($approvedItems); echo "</pre>";
            
            echo "<h2>4. Testing ClaimedItemModel</h2>";
            $claimedItemModel = new \App\Models\ClaimedItemModel();
            $claimedItems = $claimedItemModel->getClaimedItemsWithDetails();
            echo "Count: " . count($claimedItems) . "<br>";
            echo "<pre>"; print_r($claimedItems); echo "</pre>";
            
            echo "<h1 style='color: green;'>All Tests Passed!</h1>";
            
        } catch (\Exception $e) {
            echo "<h1 style='color: red;'>Error: " . $e->getMessage() . "</h1>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}

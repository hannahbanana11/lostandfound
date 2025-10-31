<?php

namespace App\Controllers;

use App\Models\FoundItemModel;
use App\Models\ClaimedItemModel;

class Timeline extends BaseController
{
    // Public timeline showing all approved items (system logic)
    public function index()
    {
        $session = session();
        $user = $session->get('user'); // Check if user is logged in
        
        $foundItemModel = new FoundItemModel();
        $claimedItemModel = new ClaimedItemModel();
        
        // Get only approved items for public timeline (as per system specification)
        // Exclude items that have been successfully claimed (approved claims)
        $approvedItems = $foundItemModel->select('found_items.*')
                                       ->join('claimed_items', 'claimed_items.item_id = found_items.id AND claimed_items.status = "approved"', 'left')
                                       ->where('found_items.status', 'approved')
                                       ->where('claimed_items.id IS NULL') // Only items without approved claims
                                       ->orderBy('found_items.date_reported', 'DESC')
                                       ->findAll();

        // For each item, check if it has any pending claims
        foreach ($approvedItems as &$item) {
            $claimStatus = $claimedItemModel->where('item_id', $item['id'])
                                          ->where('status', 'pending')
                                          ->first();
            $item['claim_status'] = $claimStatus;
        }
        
        $data = [
            'items' => $approvedItems,
            'title' => 'Lost & Found Timeline - Find Your Items',
            'user' => $user // Pass user session to view
        ];
        
        return view('timeline/index', $data);
    }

    // Show claim form for a specific item
    public function showClaimForm($itemId)
    {
        $session = session();
        $user = $session->get('user');
        
        // Must be logged in to claim
        if (!$user) {
            return redirect()->to('/auth')->with('error', 'Please login to claim an item.');
        }
        
        $foundItemModel = new FoundItemModel();
        $item = $foundItemModel->where('id', $itemId)
                              ->where('status', 'approved')
                              ->first();
        
        if (!$item) {
            return redirect()->to('/timeline')->with('error', 'Item not found or not available for claiming.');
        }
        
        // Prevent users from claiming their own items
        if ($item['user_id'] == $user['id']) {
            return redirect()->to('/timeline')->with('error', 'You cannot claim an item that you reported yourself.');
        }
        
        // Check if item is already claimed
        $claimedItemModel = new ClaimedItemModel();
        $existingClaim = $claimedItemModel->where('item_id', $itemId)
                                         ->whereIn('status', ['pending', 'approved'])
                                         ->first();

        if ($existingClaim) {
            return redirect()->to('/timeline')->with('error', 'This item already has a pending or approved claim.');
        }

        $data = [
            'item' => $item,
            'title' => 'Claim Item: ' . $item['item_name'],
            'user' => $user
        ];

        return view('timeline/claim_form', $data);
    }

    // Process claim submission
    public function processClaim()
    {
        $session = session();
        $user = $session->get('user');
        
        // Must be logged in to claim
        if (!$user) {
            return redirect()->to('/auth')->with('error', 'Please login to claim an item.');
        }
        
        $itemId = $this->request->getPost('item_id');
        $claimantName = $this->request->getPost('claimant_name');
        $claimantContact = $this->request->getPost('claimant_contact');
        $description = $this->request->getPost('description');
        
        // Validation
        if (empty($itemId) || empty($claimantName) || empty($claimantContact) || empty($description)) {
            return redirect()->back()->with('error', 'All fields are required.');
        }
        
        // Check if item exists and is available
        $foundItemModel = new FoundItemModel();
        $item = $foundItemModel->where('id', $itemId)
                              ->where('status', 'approved')
                              ->first();
        
        if (!$item) {
            return redirect()->to('/timeline')->with('error', 'Item not found or not available for claiming.');
        }
        
        // Prevent users from claiming their own items
        if ($item['user_id'] == $user['id']) {
            return redirect()->to('/timeline')->with('error', 'You cannot claim an item that you reported yourself.');
        }
        
        // Check if item is already claimed
        $claimedItemModel = new ClaimedItemModel();
        $existingClaim = $claimedItemModel->where('item_id', $itemId)
                                         ->whereIn('status', ['pending', 'approved'])
                                         ->first();

        if ($existingClaim) {
            return redirect()->to('/timeline')->with('error', 'This item already has a pending or approved claim.');
        }

        // Create new claim
        $claimData = [
            'item_id' => $itemId,
            'claimant_user_id' => $user['id'],
            'claimant_name' => $claimantName,
            'claimant_contact' => $claimantContact,
            'date_claimed' => date('Y-m-d H:i:s'),
            'notes' => $description,
            'status' => 'pending'
        ];
        
        if ($claimedItemModel->insert($claimData)) {
            return redirect()->to('/timeline')->with('success', 'Your claim has been submitted successfully! An admin will review it shortly.');
        } else {
            return redirect()->back()->with('error', 'Failed to submit claim. Please try again.');
        }
    }

    // Cancel a claim
    public function cancelClaim($claimId)
    {
        $session = session();
        $user = $session->get('user');
        
        if (!$user) {
            return redirect()->to('/auth')->with('error', 'Please login to cancel a claim.');
        }

        $claimedItemModel = new ClaimedItemModel();
        $claim = $claimedItemModel->where('id', $claimId)
                                 ->where('claimant_user_id', $user['id'])
                                 ->where('status', 'pending')
                                 ->first();

        if (!$claim) {
            return redirect()->to('/timeline')->with('error', 'Claim not found or cannot be cancelled.');
        }

        if ($claimedItemModel->delete($claimId)) {
            return redirect()->to('/timeline')->with('success', 'Your claim has been cancelled successfully.');
        } else {
            return redirect()->to('/timeline')->with('error', 'Failed to cancel claim. Please try again.');
        }
    }
}
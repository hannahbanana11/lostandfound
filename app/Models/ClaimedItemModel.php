<?php

namespace App\Models;
use CodeIgniter\Model;

class ClaimedItemModel extends Model
{
    protected $table = 'claimed_items';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'item_id',
        'claimant_user_id',
        'claimant_name',
        'claimant_contact',
        'date_claimed',
        'verified_by',
        'notes',
        'status'
    ];
    
    protected $useTimestamps = false;
    
    // Get claimed item with found item details (only approved claims)
    public function getClaimedItemsWithDetails()
    {
        return $this->select('claimed_items.*, found_items.item_name, found_items.description, found_items.image, found_items.founder_name, found_items.contact_number, found_items.location, users.username as verified_by_name')
                    ->join('found_items', 'found_items.id = claimed_items.item_id', 'left')
                    ->join('users', 'users.id = claimed_items.verified_by', 'left')
                    ->where('claimed_items.status', 'approved')
                    ->orderBy('claimed_items.date_claimed', 'DESC')
                    ->findAll();
    }

    // Get pending claims for admin review
    public function getPendingClaimsWithDetails()
    {
        return $this->select('claimed_items.*, found_items.item_name, found_items.description, found_items.image, found_items.founder_name, found_items.contact_number, found_items.location')
                    ->join('found_items', 'found_items.id = claimed_items.item_id')
                    ->where('claimed_items.status', 'pending')
                    ->orderBy('claimed_items.date_claimed', 'DESC')
                    ->findAll();
    }

    // Get claims made by a specific user
    public function getClaimsByUser($userId)
    {
        return $this->select('claimed_items.*, found_items.item_name, found_items.description, found_items.image, found_items.founder_name, found_items.contact_number, found_items.location')
                    ->join('found_items', 'found_items.id = claimed_items.item_id')
                    ->where('claimed_items.claimant_user_id', $userId)
                    ->orderBy('claimed_items.date_claimed', 'DESC')
                    ->findAll();
    }

    // Check if item has any pending or approved claims
    public function getItemClaimStatus($itemId)
    {
        return $this->where('item_id', $itemId)
                    ->whereIn('status', ['pending', 'approved'])
                    ->first();
    }
}

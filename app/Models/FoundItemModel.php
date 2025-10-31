<?php

namespace App\Models;
use CodeIgniter\Model;

class FoundItemModel extends Model
{
    protected $table = 'found_items';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'founder_name',
        'contact_number',
        'item_name',
        'description',
        'location',
        'image',
        'status',
        'claimer_id',
        'claimed_date',
        'claimed_by',
        'claim_date',
        'date_reported'
    ];
    
    protected $useTimestamps = false;
    
    // Get found items with user details
    public function getFoundItemsWithUser($status = null)
    {
        $builder = $this->select('found_items.*, users.username, users.email')
                        ->join('users', 'users.id = found_items.user_id', 'left');
        
        if ($status !== null) {
            $builder->where('found_items.status', $status);
        }
        
        return $builder->orderBy('found_items.date_reported', 'DESC')->findAll();
    }
    
    // Get statistics for admin dashboard
    public function getStatistics()
    {
        return [
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'claimed' => $this->where('status', 'claimed')->countAllResults(),
            'total' => $this->countAllResults(false)
        ];
    }
}
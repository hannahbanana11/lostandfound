<?php

namespace App\Controllers;

use App\Models\FoundItemModel;
use App\Models\ClaimedItemModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            return redirect()->to('/auth');
        }

        // Role-based redirect as per system logic
        if (is_array($user) && isset($user['role']) && $user['role'] === 'admin') {
            // Admin Dashboard - shows pending reports, approved items, claimed items
            $foundItemModel = new FoundItemModel();
            $claimedItemModel = new ClaimedItemModel();
            
            $data = [
                'user' => $user,
                'statistics' => $foundItemModel->getStatistics(),
                'pendingItems' => $foundItemModel->getFoundItemsWithUser('pending'),
                'pendingClaims' => $claimedItemModel->getPendingClaimsWithDetails(),
                'approvedItems' => $foundItemModel->getFoundItemsWithUser('approved'),
                'claimedItems' => $claimedItemModel->getClaimedItemsWithDetails()
            ];
            
            return view('dashboard/admin', $data);
        } else {
            // User Dashboard - shows user's posted items and their status
            $foundItemModel = new FoundItemModel();
            
            $data = [
                'user' => $user,
                'myItems' => $foundItemModel->where('user_id', $user['id'])
                                           ->orderBy('date_reported', 'DESC')
                                           ->findAll()
            ];
            
            return view('dashboard/user', $data);
        }
    }

    // Users post found items (status = 'pending' by default)
    public function report()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            return redirect()->to('/auth');
        }

        if ($this->request->getMethod() === 'POST') {
            return $this->processReport();
        }

        return view('dashboard/report', ['user' => $user]);
    }

    private function processReport()
    {
        $session = session();
        $user = $session->get('user');

        // Validation rules as per system specification
        $rules = [
            'founder_name' => 'required|min_length[2]|max_length[100]',
            'contact_number' => 'required|min_length[10]|max_length[20]',
            'item_name' => 'required|min_length[2]|max_length[100]',
            'description' => 'required|min_length[5]',
            'location' => 'required|min_length[3]|max_length[255]',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return view('dashboard/report', [
                'user' => $user,
                'validation' => $this->validator
            ]);
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = null;

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads', $imageName);
        }

        // Save found item with status = 'pending' (as per system logic)
        $foundItemModel = new FoundItemModel();
        $data = [
            'user_id' => $user['id'],
            'founder_name' => $this->request->getPost('founder_name'),
            'contact_number' => $this->request->getPost('contact_number'),
            'item_name' => $this->request->getPost('item_name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'image' => $imageName,
            'status' => 'pending', // Awaiting admin approval
            'date_reported' => date('Y-m-d H:i:s')
        ];

        if ($foundItemModel->save($data)) {
            return redirect()->to('/dashboard')->with('success', 'Item reported successfully! Waiting for admin approval.');
        } else {
            return redirect()->back()->with('error', 'Failed to report item. Please try again.');
        }
    }

    // Admin approves pending items (status: pending → approved)
    public function approve($id)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth');
        }

        $foundItemModel = new FoundItemModel();
        $item = $foundItemModel->find($id);

        if (!$item) {
            return redirect()->to('/dashboard')->with('error', 'Item not found.');
        }

        // Update status from 'pending' to 'approved' (system logic)
        if ($foundItemModel->update($id, ['status' => 'approved'])) {
            return redirect()->to('/dashboard')->with('success', 'Item approved! Now visible on public timeline.');
        } else {
            return redirect()->to('/dashboard')->with('error', 'Failed to approve item.');
        }
    }

    // Admin rejects items (removes from system)
    public function reject($id)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth');
        }

        $foundItemModel = new FoundItemModel();
        $item = $foundItemModel->find($id);

        if (!$item) {
            return redirect()->to('/dashboard')->with('error', 'Item not found.');
        }

        // Delete image file if exists
        if ($item['image']) {
            $imagePath = ROOTPATH . 'public/uploads/' . $item['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($foundItemModel->delete($id)) {
            return redirect()->to('/dashboard')->with('success', 'Item rejected and removed from system.');
        } else {
            return redirect()->to('/dashboard')->with('error', 'Failed to reject item.');
        }
    }

    // Admin marks item as claimed
    public function showClaimForm($id)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth');
        }

        $foundItemModel = new FoundItemModel();
        $item = $foundItemModel->getFoundItemsWithUser();
        $item = array_filter($item, function($i) use ($id) {
            return $i['id'] == $id && $i['status'] == 'approved';
        });

        if (empty($item)) {
            return redirect()->to('/dashboard')->with('error', 'Item not found or not approved.');
        }

        $item = array_values($item)[0];

        return view('dashboard/claim_form', [
            'user' => $user,
            'item' => $item
        ]);
    }

    // Process claim (status: approved → claimed)
    public function processClaim($id)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth');
        }

        $rules = [
            'claimant_name' => 'required|min_length[2]|max_length[100]',
            'claimant_contact' => 'required|min_length[10]|max_length[20]',
            'notes' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please fill all required fields correctly.');
        }

        $foundItemModel = new FoundItemModel();
        $claimedItemModel = new ClaimedItemModel();

        // Check if item exists and is approved
        $item = $foundItemModel->find($id);
        if (!$item || $item['status'] !== 'approved') {
            return redirect()->to('/dashboard')->with('error', 'Item not found or not approved.');
        }

        // Save claim record in claimed_items table (as per system logic)
        $claimData = [
            'item_id' => $id,
            'claimant_name' => $this->request->getPost('claimant_name'),
            'claimant_contact' => $this->request->getPost('claimant_contact'),
            'verified_by' => $user['id'], // Admin who verified
            'notes' => $this->request->getPost('notes'),
            'date_claimed' => date('Y-m-d H:i:s'),
            'status' => 'approved'
        ];

        if ($claimedItemModel->save($claimData)) {
            // Update found item status to 'claimed'
            $foundItemModel->update($id, ['status' => 'claimed']);
            return redirect()->to('/dashboard')->with('success', 'Item marked as claimed successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to process claim. Please try again.');
        }
    }

    // Admin approves a pending claim from timeline
    public function approveClaim($claimId)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth')->with('error', 'Admin access required.');
        }

        $claimedItemModel = new ClaimedItemModel();
        $foundItemModel = new FoundItemModel();

        // Get the claim
        $claim = $claimedItemModel->find($claimId);
        if (!$claim || $claim['status'] !== 'pending') {
            return redirect()->to('/dashboard')->with('error', 'Claim not found or already processed.');
        }

        // Update claim status to approved and add admin verification
        $updateData = [
            'status' => 'approved',
            'verified_by' => $user['id']
        ];

        if ($claimedItemModel->update($claimId, $updateData)) {
            // Update the found item status to 'claimed'
            $foundItemModel->update($claim['item_id'], ['status' => 'claimed']);
            return redirect()->to('/dashboard')->with('success', 'Claim approved successfully! Item marked as claimed.');
        } else {
            return redirect()->to('/dashboard')->with('error', 'Failed to approve claim. Please try again.');
        }
    }

    // Admin rejects a pending claim from timeline
    public function rejectClaim($claimId)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/auth')->with('error', 'Admin access required.');
        }

        $claimedItemModel = new ClaimedItemModel();

        // Get the claim
        $claim = $claimedItemModel->find($claimId);
        if (!$claim || $claim['status'] !== 'pending') {
            return redirect()->to('/dashboard')->with('error', 'Claim not found or already processed.');
        }

        // Delete the rejected claim
        if ($claimedItemModel->delete($claimId)) {
            return redirect()->to('/dashboard')->with('success', 'Claim rejected and removed.');
        } else {
            return redirect()->to('/dashboard')->with('error', 'Failed to reject claim. Please try again.');
        }
    }
}
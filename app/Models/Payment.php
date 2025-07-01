<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function get_status(){
        $status = $this->status;
        if($status == 0){
            return 'PENDING';
        }elseif($status == 1){
            return 'DECLINED';
        }elseif($status == 2){
            return 'SUCCESS';
        }
    }

    public function get_badge_status(){
        $status = $this->status;
        if($status == 0){
            return 'btn-warning';
        }elseif($status == 1){
            return 'btn-danger';
        }elseif($status == 2){
            return 'btn-success';
        }
    }
    public function get_badge_invoice_status(){
        $status = $this->status;
        if($status == 0){
            return 'badge text-bg-warning text-white';
        }elseif($status == 1){
            return 'badge text-bg-danger text-white';
        }elseif($status == 2){
            return 'badge text-bg-success text-white';
        }
    }
    
    public function getCard(){
        $merchant = $this->merchants->merchant;
        if($merchant == 0){
            // Stripe
            return 'testing';
            return strtoupper(json_decode($this->return_response)->charges->data[0]->payment_method_details->card->brand) . ' **** **** ****' . json_decode($this->return_response)->charges->data[0]->payment_method_details->card->last4;
        }else if($merchant == 4){
            // Authorize
            return ' **** **** **** ' .substr(json_decode($this->payment_data)->cc_number, -4);
        }else if($merchant == 3){
            return ' **** **** **** ' .substr(json_decode($this->payment_data)->cardnumber, -4);
        }
    }
    
    public function getCardBrand(){
        $merchant = $this->merchants->merchant;
        if($merchant == 0){
            return 'testing';
            return strtoupper(json_decode($this->return_response)->charges->data[0]->payment_method_details->card->brand);
        }else if($merchant == 4){
            return strtoupper(json_decode($this->authorize_response)->card_brand);
        }else if($merchant == 3){
            return 'FETCH';
        }
    }
    
    public function getMerchant(){
        if($this->merchant == 0){
            return 'STRIPE';
        }else if($this->merchant == 3){
            return 'FETCH';
        }else if($this->merchant == 4){
            return 'AUTHORIZE';
        }else if($this->merchant == 5){
            return 'PAYPAL';
        }
    }

    public function merchants(){
        return $this->hasOne(Merchant::class, 'id', 'merchant');
    }
}

<?php 
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ModelLogin extends Model{
        protected $table = 'users';
        protected $fillable = ['name', 'email', 'password'];
    }
?>
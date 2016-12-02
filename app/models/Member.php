<?php 

/**
* model member
*/          
class Member extends model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email'];
}
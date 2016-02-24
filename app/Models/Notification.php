<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Notification extends BaseModel {

	protected $table = 'notifications';

	protected $guarded = ['id'];

	public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeUnread($query)
	{
	    return $query->where('is_read', '=', 0);
	}

	public function withBody($body)
	{
	    $this->body = $body;
	    return $this;
	}
	 
	public function withType($type)
	{
	    $this->type = $type;
	    return $this;
	}
	 
	public function regarding($object)
	{
	    if(is_object($object))
	    {
	        $this->object_id   = $object->id;
	        $this->object_type = get_class($object);
	        $this->status = $object->status;
	    }
	 
	    return $this;
	}

	public function deliver()
	{
	    $this->save();
	    return $this;
	}

	public function hasValidObject()
	{
	    try
	    {
	        $object = call_user_func_array($this->object_type . '::findOrFail', [$this->object_id]);
	    }
	    catch(\Exception $e)
	    {
	        return false;
	    }
	 
	    $this->relatedObject = $object;
	 
	    return true;
	}
 
	public function getObject()
	{
	    if(!$this->relatedObject)
	    {
	        $hasObject = $this->hasValidObject();
	 
	        if(!$hasObject)
	        {
	            throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this notification.", $this->object_type, $this->object_id));
	        }
	    }
	 
	    return $this->relatedObject;
	}
}
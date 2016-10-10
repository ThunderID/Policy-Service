<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Policy as Model; 

/**
 * Used in CLient model
 *
 * @author cmooy
 */
class PolicyObserver 
{
	public function saving($model)
	{
		$model->slug 			= $this->generateslug($model->name, (is_null($model->id) ? 0 : $model->id));

		return true;
	}

	public function generateslug($name, $id)
	{
		do
		{
			$name 				= $name.'-'.uniqid();

			$slug 				= Str::slug($name);

			$exists_slug 		= Model::slug($slug)->notid($id)->first();
		}

		while($exists_slug);

		return $slug;
	}
}

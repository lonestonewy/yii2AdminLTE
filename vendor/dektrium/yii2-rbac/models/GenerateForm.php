<?php
namespace dektrium\rbac\models;

use yii\base\Model;
/**
* Generation form class file.
*
*/
class GenerateForm extends Model
{
	public $items;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('items', 'safe'),
		);
	}
}

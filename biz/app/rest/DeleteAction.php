<?php
namespace biz\app\rest;
/**
 * Description of DeleteAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class DeleteAction extends Action
{
    public function run($id)
    {
        $helperClass = $this->helperClass;
        return $helperClass::delete($id);
    }    
}
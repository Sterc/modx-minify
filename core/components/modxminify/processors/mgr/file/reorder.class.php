<?php
/**
 * Reorder items
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyReorderFileUpdateProcessor extends modObjectProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function process(){
        $idItem = $this->getProperty('idItem');
        $oldIndex = $this->getProperty('oldIndex');
        $newIndex = $this->getProperty('newIndex');


        $items = $this->modx->newQuery($this->classKey);
        $items->where(array(
                "id:!=" => $idItem,
                "position:>=" => min($oldIndex, $newIndex),
                "position:<=" => max($oldIndex, $newIndex),
            ));

        $items->sortby('position', 'ASC');

        $itemsCollection = $this->modx->getCollection($this->classKey, $items);

        if(min($oldIndex, $newIndex) == $newIndex){
            foreach ($itemsCollection as $item) {
                $itemObject = $this->modx->getObject($this->classKey, $item->get('id'));
                $itemObject->set('position', $itemObject->get('position') + 1);
                $itemObject->save();
            }
        }else{
            foreach ($itemsCollection as $item) {
                $itemObject = $this->modx->getObject($this->classKey, $item->get('id'));
                $itemObject->set('position', $itemObject->get('position') - 1);
                $itemObject->save();
            }
        }

        $itemObject = $this->modx->getObject($this->classKey, $idItem);
        $itemObject->set('position', $newIndex);
        $itemObject->save();

        // empty the minified cache files
        $modxminify = $this->modx->getService('modxminify','modxMinify',$this->modx->getOption('modxminify.core_path',null,$this->modx->getOption('core_path').'components/modxminify/').'model/modxminify/',array());
        if (!($modxminify instanceof modxMinify)) return '';
        $modxminify->emptyMinifyCache($itemObject->get('group'));

        return $this->success('', $itemObject);
    }

}
return 'modxMinifyReorderFileUpdateProcessor';

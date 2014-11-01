<?php
/**
 * Bake Template for Controller action generation.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.console.libs.template.objects
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

function <?php echo $admin ?>index() {
$this-><?php echo $currentModelName ?>->recursive = 0;
$this->set('<?php echo $pluralName ?>', $this->paginate());
}

function <?php echo $admin ?>view($id = null) {
if (!$id) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('Invalid <?php echo strtolower($singularHumanName) ?>', true));
    $this->redirect(array('action' => 'index'));
<?php else: ?>
    $this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>', true), array('action' => 'index'));
<?php endif; ?>
}
$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
}

<?php $compact = array(); ?>
function <?php echo $admin ?>add() {
if (!empty($this->data)) {
$this-><?php echo $currentModelName; ?>->create();
if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved', true),'success');
    $this->redirect(array('action' => 'index'));
<?php else: ?>
    $this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.', true), array('action' => 'index'));
<?php endif; ?>
} else {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', true),'fail');
<?php endif; ?>
}
}
<?php
foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
    foreach ($modelObj->{$assoc} as $associationName => $relation):
        if (!empty($associationName)):
            $otherModelName = $this->_modelName($associationName);
            $otherPluralName = $this->_pluralName($associationName);
            echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
            $compact[] = "'{$otherPluralName}'";
        endif;
    endforeach;
endforeach;
if (!empty($compact)):
    echo "\t\t\$this->set(compact(" . join(', ', $compact) . "));\n";
endif;
?>
}

<?php $compact = array(); ?>
function <?php echo $admin; ?>edit($id = null) {
if (!$id && empty($this->data)) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('Invalid <?php echo strtolower($singularHumanName); ?>', true),'fail');
    $this->redirect(array('action' => 'index'));
<?php else: ?>
    $this->flash(sprintf(__('Invalid <?php echo strtolower($singularHumanName); ?>', true)), array('action' => 'index'));
<?php endif; ?>
}
if (!empty($this->data)) {
if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved', true),'success');
    $this->redirect(array('action' => 'index'));
<?php else: ?>
    $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.', true), array('action' => 'index'));
<?php endif; ?>
} else {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', true),'fail');
<?php endif; ?>
}
}
if (empty($this->data)) {
$this->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
}
<?php
foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
    foreach ($modelObj->{$assoc} as $associationName => $relation):
        if (!empty($associationName)):
            $otherModelName = $this->_modelName($associationName);
            $otherPluralName = $this->_pluralName($associationName);
            echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
            $compact[] = "'{$otherPluralName}'";
        endif;
    endforeach;
endforeach;
if (!empty($compact)):
    echo "\t\t\$this->set(compact(" . join(', ', $compact) . "));\n";
endif;

?>
$this->render('<?php echo $admin; ?>add');
}

function <?php echo $admin; ?>delete($id = null) {
if (!$id) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('Invalid id for <?php echo strtolower($singularHumanName); ?>', true),'fail');
    $this->redirect(array('action'=>'index'));
<?php else: ?>
    $this->flash(sprintf(__('Invalid <?php echo strtolower($singularHumanName); ?>', true)), array('action' => 'index'));
<?php endif; ?>
}
if ($this-><?php echo $currentModelName; ?>->delete($id)) {
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true),'success');
    $this->redirect(array('action'=>'index'));
<?php else: ?>
    $this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), array('action' => 'index'));
<?php endif; ?>
}
<?php if ($wannaUseSession): ?>
    $this->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true),'fail');
<?php else: ?>
    $this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true), array('action' => 'index'));
<?php endif; ?>
$this->redirect(array('action' => 'index'));
}

function <?php echo $admin; ?>do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this-><?php echo $currentModelName; ?>->deleteAll(array('<?php echo $currentModelName; ?>.id' => $ids))) {
                $this->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted successfully',true), 'success');
            } else {
                $this->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> can not be deleted',true), 'fail');
            }
        }
        $this->redirect(array('action' => 'index'));
    }
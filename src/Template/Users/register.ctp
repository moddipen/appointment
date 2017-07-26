<!-- File: src/Template/Users/login.ctp -->

<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Register as a new user') ?></legend>
        <?= $this->Form->control('first_name') ?>
        <?= $this->Form->control('last_name') ?>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('email',['type' => 'email']) ?>
        <?= $this->Form->control('usertype',['type' => 'select','options'=>['Patient','Doctor']]) ?>

    </fieldset>
<?= $this->Form->button(__('Register')); ?>
<?= $this->Form->end() ?>
</div>
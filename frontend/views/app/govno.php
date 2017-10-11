<?php 

$this->title = 'Govno ebanoe !';

use dosamigos\ckeditor\CKEditorInline;

// First we need to tell CKEDITOR variable where is our external plugin 
// $this->registerJs("CKEDITOR.plugins.addExternal('pbckcode', '/pbckcode/plugin.js', '');");


?>

<?php CKEditorInline::begin(['preset' => 'custom', 'clientOptions' => [
    // 'extraPlugins' => 'pbckcode',
    'toolbarGroups' => [
        ['name' => 'undo'],
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
        ['name' => 'colors'],
        ['name' => 'links', 'groups' => ['links', 'insert']],
        ['name' => 'others', 'groups' => ['others', 'about']],
        
        // ['name' => 'pbckcode'] // <--- OUR NEW PLUGIN YAY!
    ]
]]) ?>

<p>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
    dolore magna aliqua. 
</p>
<?php CKEditorInline::end() ?>
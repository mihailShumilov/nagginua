<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\RssSources */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="rss-sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model,
        'source_id' )->dropDownList( \yii\helpers\ArrayHelper::map( \common\models\Sources::find()->orderBy( 'label' )->asArray()->all(),
        'id',
        'label' ), [ 'value' => $model->source_id ] ) ?>

    <?= $form->field( $model, 'url' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'active' )->checkbox() ?>

    <?= $form->field( $model, 'is_full' )->checkbox() ?>

    <?php

        $settingsFields = [
            "rss_news_item_pattern" => [
                "label"        => "Item pattern",
                "defaultValue" => "//item"
            ],
            "rss_title"             => [
                "label"        => "Title",
                "defaultValue" => "title"
            ],
            "rss_link"              => [
                "label"        => "Link",
                "defaultValue" => "link"
            ],
            "rss_image"             => [
                "label"        => "Image",
                "defaultValue" => "enclosure"
            ],
            "rss_content"           => [
                "label"        => "Content",
                "defaultValue" => "yandex:full-text"
            ],
            "rss_category"          => [
                "label"        => "Category",
                "defaultValue" => "category"
            ]
        ];
        foreach ($settingsFields as $key => $data):
            $placeholder = $data['defaultValue'];
            $pattern     = false;
            if ($settings = \common\models\SourcesSettings::findOne( [
                'source_id' => $model->source_id,
                "name"      => $key
            ] )
            ) {
                $pattern = $settings->value;
            }
            ?>
            <div class="form-group field-<?= $key ?> ">
                <label class="control-label" for="<?= $key ?>"><?= $data['label'] ?></label>
                <input type="text" id="<?= $key ?>" class="form-control" name="RssSources[settings][<?= $key ?>]"
                       value="<?= $pattern; ?>" maxlength="255" placeholder="<?= $placeholder ?>">
            </div>

        <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\widgets\ListView;
use open20\amos\sondaggi\AmosSondaggi;
use open20\design\assets\BootstrapItaliaDesignAsset;
use open20\amos\admin\AmosAdmin;
use yii\helpers\Html;
use open20\design\utility\DesignUtility;


$currentAsset = BootstrapItaliaDesignAsset::register($this);

$isGuest = \Yii::$app->user->isGuest;

?>


<?php
$modelLabel = strtolower($model->getGrammar()->getModelLabel());
?>
<div class="modulo-backend-<?= $modelLabel ?> <?= $cssClass ?>">
    <?php if (!($cssClass == 'hide-bi-plugin-header')) : ?>
        <?php
        $modelLabel = strtolower($model->getGrammar()->getModelLabel());

        //COPIA CONTENUTO DI BEFOREACTION IN CONTROLLER SONDAGGI - TODO DA RENDERE STATIC
        if (\Yii::$app->user->isGuest) {
            $titleSection = AmosSondaggi::t('amossondaggi', 'Sondaggi');
            $labelLinkAll = AmosSondaggi::t('amossondaggi', 'Tutti i sondaggi');
            $urlLinkAll   = '/sondaggi/pubblicazione/all';
            $titleLinkAll = AmosSondaggi::t('amossondaggi', 'Visualizza la lista dei sondaggi pubblicati');

            $ctaLoginRegister = Html::a(
                AmosSondaggi::t('amossondaggi', '#beforeActionCtaLoginRegister'),
                isset(\Yii::$app->params['linkConfigurations']['loginLinkCommon']) ? \Yii::$app->params['linkConfigurations']['loginLinkCommon']
                    : \Yii::$app->params['platform']['backendUrl'] . '/' . AmosAdmin::getModuleName() . '/security/login',
                [
                    'title' => AmosSondaggi::t(
                        'amossondaggi',
                        'Clicca per accedere o registrarti alla piattaforma {platformName}',
                        ['platformName' => \Yii::$app->name]
                    )
                ]
            );
            $subTitleSection  = Html::tag(
                'p',
                AmosSondaggi::t(
                    'amossondaggi',
                    '#beforeActionSubtitleSectionGuest',
                    ['ctaLoginRegister' => $ctaLoginRegister]
                )
            );
        } else {
            $titleSection = AmosSondaggi::t('amossondaggi', 'Sondaggi di mio interesse');
            $labelLinkAll = AmosSondaggi::t('amossondaggi', 'Tutte i sondaggi di mio interesse');
            $urlLinkAll   = '/sondaggi/pubblicazione/own-interest';
            $titleLinkAll = AmosSondaggi::t('amossondaggi', 'Visualizza la lista dei sondaggi di tuo interesse');

            $subTitleSection = Html::tag('p', AmosSondaggi::t('amossondaggi', '#beforeActionSubtitleSectionLogged'));
        }

        $labelCreate = AmosSondaggi::t('amossondaggi', 'Nuovo');
        $titleCreate = AmosSondaggi::t('amossondaggi', 'Crea un nuovo sondaggio');
        $labelManage = AmosSondaggi::t('amossondaggi', 'Gestisci');
        $titleManage = AmosSondaggi::t('amossondaggi', 'Gestisci i sondaggi');
        $urlCreate   = AmosSondaggi::t('amossondaggi', '/sondaggi/sondaggi/create');

        $manageLinks = [];
        $controller = \open20\amos\sondaggi\controllers\SondaggiController::class;
        if (method_exists($controller, 'getManageLinks')) {
            $manageLinks = $controller::getManageLinks();
        }
        $canCreate = \Yii::$app->user->can('SONDAGGI_CREATE', ['model' => $model]);

        ?>
        <?=
        $this->render(
            '@vendor/open20/design/src/views/layouts/parts/bi-plugin-header',
            [
                'isGuest' => $isGuest,
                'modelLabel' => $modelLabel,
                'titleSection' => $titleSection,
                'subTitleSection' => $subTitleSection,
                'urlLinkAll' => $urlLinkAll,
                'labelLinkAll' => $labelLinkAll,
                'titleLinkAll' => $titleLinkAll,
                'canCreate' => $canCreate,
                'labelCreate' => $labelCreate,
                'titleCreate' => $titleCreate,
                'labelManage' => $labelManage,
                'titleManage' => $titleManage,
                'urlCreate' => $urlCreate,
                'manageLinks' => $manageLinks,
            ]
        );
        ?>
    <?php endif ?>

    <div class="card-<?= $modelLabel ?>-container">
        <?php
        if ($dataProvider->getTotalCount() > 0) {

            $listViewLayout = $this->render('@vendor/open20/design/src/components/yii2/views/listViewLayout');

            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_itemCardSondaggiDesign',
                'viewParams' => [
                    'detailPage' => $detailPage,
                    'viewFields' => $viewFields,
                    'blockItemId' => $blockItemId,
                ],
                'layout' => $listViewLayout,
                'summary' => DesignUtility::getLayoutSummary($withPagination),
                'pager' => DesignUtility::listViewPagerConfig(),
                'itemOptions' => [
                    'tag' => false
                ],
                'options' => [
                    'class' => 'list-view w-100'
                ]
            ]);
        } else { ?>
            <?php if (!$isGuest) : ?>
                <div class="no-<?= str_replace(' ', '-', $modelLabel) ?>-alert">
                    <p><?= BaseAmosModule::t('amosapp', 'Non ci sono contenuti che corrispondono ai tuoi interessi') ?></p>
                </div>
            <?php endif; ?>
        <?php } ?>
    </div>
</div>
<?php
/** @var $model \app\forms\MemberUpdateForm */

$this->title = 'Inscription update';
$this->jsFile = 'updateMemberAccount';

use app\core\Application;
use app\core\Mailer;

?>
<div class="flex gap-2">
    <x-tabs class="column" save>
        <x-tab role="heading" slot="tab" id="info">
            <i data-lucide="user"></i>
            Informations personnelles
        </x-tab>

        <x-tab-panel role="region" slot="panel">
            <div class="flex flex-row mb-8 items-center">
                <img class="w-[125px] h-[125px] rounded-full mr-10 object-cover" src="<?php echo Application::$app->user->avatar_url ?>">
                <button id="avatarUpdate" type="button" class="button w-25% gray"><i data-lucide="pen-line"></i>Modifier mon avatar</button>
            </div>
            <?php $form = \app\core\form\Form::begin('', 'post', '', 'flex flex-col justify-center items-center') ?>
            <input type="hidden" name="form-name" value="update-main">
            <div class="flex flex-col w-full gap-6">
                <div class="form-inputs flex flex-col gap-1">
                    <div class="flex gap-4">
                        <?php echo $form->field($model, 'lastname') ?>
                        <?php echo $form->field($model, 'firstname') ?>
                    </div>

                    <?php echo $form->field($model, 'pseudo') ?>
                    <?php echo $form->field($model, 'mail') ?>
                    <?php echo $form->field($model, 'phone') ?>
                    <div class="flex gap-4">
                        <div>
                            <?php echo $form->field($model, 'streetNumber') ?>
                        </div>
                        <?php echo $form->field($model, 'streetName') ?>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <?php echo $form->field($model, 'postalCode') ?>
                        </div>
                        <?php echo $form->field($model, 'city') ?>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex gap-4 items-center">
                        <div class="flex items-center">
                            <input class="switch" type="checkbox" id="switch-notification" name="notification" value="true"/>
                            <label class="switch" for="switch-notification"></label>
                        </div>
                        <label for="switch-period" id="switch-period-label">J’autorise l’envoi de
                            notifications concernant
                            la mise en ligne de nouvelles offres et autre</label>
                    </div>
                </div>
                
                <div class="flex flex-col gap-4 mt-8">
                    <p><?php echo $form->error($model, 'passwordCheck') ?></p>
                    <button id="saveUpdatePopupTrigger" type="button" class="button w-full">Enregistrer les modifications</button>
                </div>
            </div>
            <div id="popupSaveUpdate"
                 class="hidden lg:fixed lg:inset-0 lg:bg-black/50 flex items-center justify-center">

                <!--//////////////////////////////////////////////////////////////////////////
                // save update pop up
                //////////////////////////////////////////////////////////////////////////:-->

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="form-name" value="update-main">
                    <div class="popup-content bg-white lg:rounded-lg lg:shadow-lg lg:max-w-[900px] lg:max-h-[225px]
                        w-full h-full lg:p-10 flex flex-col items-center gap-6">
                        <div>
                            <h1  class="heading-1">Valider les modifications</h1>
                        </div>
                        <div class="w-[400px]" id="password-condition-utilisation">
                            <?php echo $form->field($model, 'passwordCheck')->passwordField() ?>
                        </div>
                        <div class="flex flex-row gap-4">
                            <div>
                                <button type="button" class="button gray w-[400px]" id="closePopupSave">Annuler</button>
                            </div>
                            <div>
                                <button type="submit" class="button w-[400px]">Enregistrer les modifications</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php \app\core\form\Form::end() ?>
        </x-tab-panel>

        <x-tab role="heading" slot="tab" id="securite">
            <i data-lucide="key"></i>
            Sécurité
        </x-tab>

        <x-tab-panel role="region" slot="panel">
            <div class="flex flex-col gap-4">
                <form method="post" class="flex">
                    <input type="hidden" name="form-name" value="reset-password">
                    <button id ="passwordModify" type="submit" class="button w-full gray">Modifier le mot de passe</button>
                </form>
                <button id ="accountDelete" type="submit" class="button danger">Supprimer mon compte</button>
            </div>
        </x-tab-panel>
    </x-tabs>
</div>

<!--//////////////////////////////////////////////////////////////////////////
// Avatar pop up
//////////////////////////////////////////////////////////////////////////:-->

<div id="popupAvatarUpdate"
     class="hidden lg:fixed lg:inset-0 lg:bg-black/50 flex items-center justify-center">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form-name" value="update-avatar">
        <div
            class="popup-content bg-white lg:rounded-lg lg:shadow-lg lg:max-w-[900px] lg:max-h-[400px]
            w-full h-full p-2 lg:p-10 flex flex-col justify-center items-center gap-6">
            <div>
                <h1  class="heading-1">Modification de votre photo de profil</h1>
            </div>
            <div>
                <img class="w-[125px] h-[125px] rounded-full object-cover" src="<?php echo Application::$app->user->avatar_url ?>">
            </div>
            <div class="flex flex-row gap-4">
                <div class="w-[200px]">
                    <label for="file" class="button w-full gray">
                        <i data-lucide="upload"></i> Importer
                    </label>
                    <input id="file" class="hidden" type="file" name="avatar">
                </div>
                <div class="w-[200px]">
                    <button class="button w-full gray">
                        <i data-lucide="trash"></i>
                        Supprimer
                    </button>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-[400px]">
                    <button type="button" class="button w-full gray" id="closePopupAvatar">Annuler</button>
                </div>
                <div class="w-[400px]">
                    <button type="submit" class="button w-full">Enregistrer les modifications</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!--//////////////////////////////////////////////////////////////////////////
// Modify Password page
//////////////////////////////////////////////////////////////////////////:

<div id="popupPasswordModify" class="hidden lg:fixed lg:inset-0 lg:bg-black/50 flex items-center justify-center">
    <div class="popup-content bg-white lg:rounded-lg lg:shadow-lg lg:max-w-[900px] lg:max-h-[400px] w-full h-full p-2 lg:p-10 flex flex-col justify-center items-center gap-6">
        <div>
            <h1  class="heading-1">Modification du mot de passe</h1>
        </div>
        <div>
            <form type="text">test</form>
        </div>
        <div class="flex flex-row gap-4">
            <div class="w-[400px]">
                <button id="closePasswordModify" type="submit" class="button w-full gray">Annuler</button>
            </div>
            <div class="w-[400px]">
                <button type="submit" class="button w-full">confirmer</button>
            </div>
        </div>
    </div>
</div> 
        -->
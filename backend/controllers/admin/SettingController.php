<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 18-02-2015
	 * Time: 16:48
	 */

	namespace backend\controllers\admin;

	use abhimanyu\installer\helpers\Configuration;
	use abhimanyu\installer\helpers\enums\Configuration as Enum;
	use backend\models\BasicSettingForm;
	use backend\models\MailFormSetting;
	use Yii;
	use yii\web\Controller;

	class SettingController extends Controller
	{
		public $layout = 'admin';

		public function actionIndex()
		{
			$model  = new BasicSettingForm();
			$themes = SettingController::getThemes();

			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
					Yii::$app->config->set(Enum::APP_NAME, $model->appName);
					Yii::$app->config->set(Enum::APP_BACKEND_THEME, $model->appBackendTheme);
					Yii::$app->config->set(Enum::APP_FRONTEND_THEME, $model->appFrontendTheme);
					Yii::$app->config->set(Enum::CACHE_CLASS, $model->cacheClass);

					$config                        = Configuration::get();
					$config['components']['cache'] = $model->cacheClass;
					Configuration::set($config);

					Yii::$app->session->setFlash('success', 'Settings Saved');
				}
			}

			return $this->render('index', ['model' => $model, 'themes' => $themes]);
		}

		private static function getThemes()
		{
			return [
				'cerulean'  => 'Cerulean',
				'cosmo'     => 'Cosmo',
				'cyborg'    => 'Cyborg',
				'darkly'    => 'Darkly',
				'flatly'    => 'Flatly',
				'journal'   => 'Journal',
				'lumen'     => 'Lumen',
				'paper'     => 'Paper',
				'readable'  => 'Readable',
				'sandstone' => 'Sandstone',
				'simplex'   => 'Simplex',
				'slate'     => 'Slate',
				'spacelab'  => 'Spacelab',
				'superhero' => 'Superhero',
				'united'    => 'United',
				'yeti'      => 'Yeti'
			];
		}

		public function actionMail()
		{
			$model = new MailFormSetting();

			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
					Yii::$app->config->set(Enum::MAILER_HOST, $model->mailHost);
					Yii::$app->config->set(Enum::MAILER_USERNAME, $model->mailUsername);
					Yii::$app->config->set(Enum::MAILER_PASSWORD, $model->mailPassword);
					Yii::$app->config->set(Enum::MAILER_PORT, $model->mailPort);
					Yii::$app->config->set(Enum::MAILER_ENCRYPTION, $model->mailEncryption);

					Yii::$app->session->setFlash('success', 'Mail Settings Saved');
				}
			}

			return $this->render('mail', ['model' => $model]);
		}
	}
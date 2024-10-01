<?php
/**
 * The admin module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id: zh-tw.php 4767 2013-05-05 06:10:13Z wwccss $
 * @link        http://www.zentao.net
 */
$lang->admin->index           = '後台管理首頁';
$lang->admin->checkDB         = '檢查資料庫';
$lang->admin->sso             = 'ZDOO整合';
$lang->admin->ssoAction       = 'ZDOO整合';
$lang->admin->safeIndex       = '安全';
$lang->admin->checkWeak       = '弱口令檢查';
$lang->admin->certifyMobile   = '認證手機';
$lang->admin->certifyEmail    = '認證郵箱';
$lang->admin->ztCompany       = '認證公司';
$lang->admin->captcha         = '驗證碼';
$lang->admin->getCaptcha      = '獲取驗證碼';
$lang->admin->register        = '登記';
$lang->admin->resetPWDSetting = '重置密碼設置';
$lang->admin->tableEngine     = '表引擎';
$lang->admin->setModuleIndex  = '系統功能配置';

$lang->admin->api            = '介面';
$lang->admin->log            = '日誌';
$lang->admin->setting        = '設置';
$lang->admin->days           = '日誌保存天數';
$lang->admin->resetPWDByMail = '通過郵箱重置密碼';

$lang->admin->changeEngine   = "更換到InnoDB";
$lang->admin->changingTable  = '正在更換數據表%s引擎...';
$lang->admin->changeSuccess  = '已經更換數據表%s引擎為InnoDB。';
$lang->admin->changeFail     = "更換數據表%s引擎失敗，原因：<span class='text-red'>%s</span>。";
$lang->admin->errorInnodb    = '您當前的資料庫不支持使用InnoDB數據表引擎。';
$lang->admin->changeFinished = "更換資料庫引擎完畢。";
$lang->admin->engineInfo     = "表<strong>%s</strong>的引擎是<strong>%s</strong>。";
$lang->admin->engineSummary['hasMyISAM'] = "有%s個表不是InnoDB引擎";
$lang->admin->engineSummary['allInnoDB'] = "所有的表都是InnoDB引擎了";

$lang->admin->info = new stdclass();
$lang->admin->info->version = '當前系統的版本是%s，';
$lang->admin->info->links   = '您可以訪問以下連結：';
$lang->admin->info->account = "您的禪道社區賬戶為%s。";
$lang->admin->info->log     = '超出存天數的日誌會被刪除，需要開啟計劃任務。';

$lang->admin->notice = new stdclass();
$lang->admin->notice->register = "友情提示：您還未在禪道社區(www.zentao.net)登記，%s進行登記，以及時獲得禪道最新信息。";
$lang->admin->notice->ignore   = "不再提示";
$lang->admin->notice->int      = "『%s』應當是正整數。";

$lang->admin->registerNotice = new stdclass();
$lang->admin->registerNotice->common     = '註冊新帳號綁定';
$lang->admin->registerNotice->caption    = '禪道社區登記';
$lang->admin->registerNotice->click      = '點擊此處';
$lang->admin->registerNotice->lblAccount = '請設置您的用戶名，英文字母和數字的組合，三位以上。';
$lang->admin->registerNotice->lblPasswd  = '請設置您的密碼。數字和字母的組合，六位以上。';
$lang->admin->registerNotice->submit     = '登記';
$lang->admin->registerNotice->bind       = "綁定已有帳號";
$lang->admin->registerNotice->success    = "登記賬戶成功";

$lang->admin->bind = new stdclass();
$lang->admin->bind->caption = '關聯社區帳號';
$lang->admin->bind->success = "關聯賬戶成功";

$lang->admin->setModule = new stdclass();
$lang->admin->setModule->module         = '功能點';
$lang->admin->setModule->optional       = '可選功能';
$lang->admin->setModule->opened         = '已開啟';
$lang->admin->setModule->closed         = '已關閉';

$lang->admin->setModule->product        = '產品';
$lang->admin->setModule->scrum          = '敏捷項目';
$lang->admin->setModule->waterfall      = '瀑布項目';
$lang->admin->setModule->assetlib       = '資產庫';
$lang->admin->setModule->other          = '通用功能';

$lang->admin->setModule->repo           = '代碼';
$lang->admin->setModule->issue          = '問題';
$lang->admin->setModule->risk           = '風險';
$lang->admin->setModule->opportunity    = '機會';
$lang->admin->setModule->process        = '過程';
$lang->admin->setModule->measrecord     = '度量';
$lang->admin->setModule->auditplan      = 'QA';
$lang->admin->setModule->meeting        = '會議';
$lang->admin->setModule->roadmap        = '路線圖';
$lang->admin->setModule->track          = '矩陣';
$lang->admin->setModule->UR             = '用戶需求';
$lang->admin->setModule->researchplan   = '調研';
$lang->admin->setModule->gapanalysis    = '培訓';
$lang->admin->setModule->storylib       = '需求庫';
$lang->admin->setModule->caselib        = '用例庫';
$lang->admin->setModule->issuelib       = '問題庫';
$lang->admin->setModule->risklib        = '風險庫';
$lang->admin->setModule->opportunitylib = '機會庫';
$lang->admin->setModule->practicelib    = '最佳實踐庫';
$lang->admin->setModule->componentlib   = '組件庫';
$lang->admin->setModule->devops         = 'DevOps';
$lang->admin->setModule->kanban         = '通用看板';
$lang->admin->setModule->OA             = '辦公';
$lang->admin->setModule->deploy         = '運維';
$lang->admin->setModule->traincourse    = '學堂';

$lang->admin->safe = new stdclass();
$lang->admin->safe->common                   = '安全策略';
$lang->admin->safe->set                      = '密碼安全設置';
$lang->admin->safe->password                 = '密碼安全';
$lang->admin->safe->weak                     = '常用弱口令';
$lang->admin->safe->reason                   = '類型';
$lang->admin->safe->checkWeak                = '弱口令掃瞄';
$lang->admin->safe->changeWeak               = '修改弱口令密碼';
$lang->admin->safe->loginCaptcha             = '登錄使用驗證碼';
$lang->admin->safe->modifyPasswordFirstLogin = '首次登錄修改密碼';
$lang->admin->safe->passwordStrengthWeak     = '密碼強度小於系統設置';

$lang->admin->safe->modeList[0] = '不檢查';
$lang->admin->safe->modeList[1] = '中';
$lang->admin->safe->modeList[2] = '強';

$lang->admin->safe->modeRuleList[1] = '6位及以上，包含大小寫字母，數字。';
$lang->admin->safe->modeRuleList[2] = '10位及以上，包含字母，數字，特殊字元。';

$lang->admin->safe->reasonList['weak']     = '常用弱口令';
$lang->admin->safe->reasonList['account']  = '與帳號相同';
$lang->admin->safe->reasonList['mobile']   = '與手機相同';
$lang->admin->safe->reasonList['phone']    = '與電話相同';
$lang->admin->safe->reasonList['birthday'] = '與生日相同';

$lang->admin->safe->modifyPasswordList[1] = '必須修改';
$lang->admin->safe->modifyPasswordList[0] = '不強制';

$lang->admin->safe->loginCaptchaList[1] = '是';
$lang->admin->safe->loginCaptchaList[0] = '否';

$lang->admin->safe->resetPWDList[1] = '開啟';
$lang->admin->safe->resetPWDList[0] = '關閉';

$lang->admin->safe->noticeMode     = '系統會在創建和修改用戶、修改密碼的時候檢查用戶口令。';
$lang->admin->safe->noticeWeakMode = '系統會在登錄、創建和修改用戶、修改密碼的時候檢查用戶口令。';
$lang->admin->safe->noticeStrong   = '密碼長度越長，含有大寫字母或數字或特殊符號越多，密碼字母越不重複，安全度越強！';
$lang->admin->safe->noticeGd       = '系統檢測到您的伺服器未安裝GD模組，無法使用驗證碼功能，請安裝後使用。';

<?php
$lang->zanode->common          = '執行節點';
$lang->zanode->browse          = '執行節點列表';
$lang->zanode->create          = '創建執行節點';
$lang->zanode->edit            = '編輯執行節點';
$lang->zanode->editAction      = '編輯執行節點';
$lang->zanode->view            = '執行節點詳情';
$lang->zanode->initTitle       = '初始化執行節點';
$lang->zanode->suspend         = '休眠執行節點';
$lang->zanode->destroy         = '銷毀執行節點';
$lang->zanode->boot            = '啟動執行節點';
$lang->zanode->reboot          = '重啟執行節點';
$lang->zanode->shutdown        = '關閉執行節點';
$lang->zanode->resume          = '恢復執行節點';
$lang->zanode->suspendNode     = '休眠';
$lang->zanode->bootNode        = '啟動';
$lang->zanode->rebootNode      = '重啟';
$lang->zanode->shutdownNode    = '關閉';
$lang->zanode->resumeNode      = '恢復';
$lang->zanode->getVNC          = '遠程';
$lang->zanode->all             = '全部';
$lang->zanode->byQuery         = '搜索';
$lang->zanode->osName          = '操作系統';
$lang->zanode->image           = '鏡像';
$lang->zanode->imageName       = '鏡像名稱';
$lang->zanode->name            = '名稱';
$lang->zanode->start           = '創建後自動開啟';
$lang->zanode->hostName        = '所屬宿主機';
$lang->zanode->host            = $lang->zanode->hostName;
$lang->zanode->extranet        = 'IP/域名';
$lang->zanode->sshAddress      = 'SSH命令';
$lang->zanode->osArch          = '架構';
$lang->zanode->cpuCores        = 'CPU';
$lang->zanode->defaultUser     = '預設用戶';
$lang->zanode->defaultPwd      = '預設密碼';
$lang->zanode->memory          = '內存';
$lang->zanode->diskSize        = '硬碟';
$lang->zanode->desc            = '描述';
$lang->zanode->status          = '狀態';
$lang->zanode->mac             = 'MAC地址';
$lang->zanode->vnc             = 'VNC連接埠';
$lang->zanode->destroyAt       = '銷毀時間';
$lang->zanode->creater         = '創建人';
$lang->zanode->createdDate     = '創建日期';
$lang->zanode->confirmDelete   = "您確定銷毀執行節點嗎？";
$lang->zanode->confirmBoot     = "您確定啟動執行節點嗎？";
$lang->zanode->confirmReboot   = "您確定重啟執行節點嗎？";
$lang->zanode->confirmShutdown = "您確定關閉執行節點嗎？";
$lang->zanode->confirmSuspend  = "您確定休眠執行節點嗎？";
$lang->zanode->confirmResume   = "您確定恢復執行節點嗎？";
$lang->zanode->actionSuccess   = '操作成功';
$lang->zanode->deleted         = "已刪除";
$lang->zanode->scriptPath      = "腳本目錄";
$lang->zanode->shell           = "shell命令";
$lang->zanode->automation      = "自動化設置";
$lang->zanode->install         = "安裝";
$lang->zanode->reinstall       = "重裝";
$lang->zanode->copy            = '複製';
$lang->zanode->copied          = '複製成功';
$lang->zanode->manual          = '手冊';
$lang->zanode->initializing    = '初始化中';

$lang->automation = new stdClass();
$lang->automation->scriptPath = $lang->zanode->scriptPath;
$lang->automation->node       = $lang->zanode->common;

$lang->zanode->notFoundAgent  = '沒有發現Agent服務';
$lang->zanode->createVmFail   = '創建執行節點失敗';
$lang->zanode->noVncPort      = '無法獲取執行節點連接埠';
$lang->zanode->nameValid      = "名稱只能是字母、數字，'-'，'_'，'.'，且不能以符號開頭";
$lang->zanode->empty          = '暫時沒有執行節點';
$lang->zanode->runCaseConfirm = '系統檢測到選擇的用例存在自動化測試腳本，是否自動執行用例？';

$lang->zanode->createImage        = '導出鏡像';
$lang->zanode->createImaging      = '正在導出鏡像';
$lang->zanode->createImageNotice  = '系統將基于當前執行節點導出鏡像，該過程需要關閉該執行節點，確定要繼續麼？';
$lang->zanode->createImageSuccess = '鏡像導出成功，您可以使用此鏡像創建執行節點。';
$lang->zanode->createImageFail    = '鏡像導出失敗';
$lang->zanode->createImageButton  = '去創建';

$lang->zanode->imageNameEmpty = '名稱不能為空';

$lang->zanode->runTimeout = '自動執行失敗，請檢查宿主機和執行節點狀態';

$lang->zanode->apiError['-10100'] = '執行節點不存在';
$lang->zanode->apiError['fail']   = '執行失敗，請檢查宿主機和執行節點狀態';

$lang->zanode->publicList[0] = '不共享';
$lang->zanode->publicList[1] = '共享';

$lang->zanode->statusList['created']      = '已創建';
$lang->zanode->statusList['launch']       = '運行中';
$lang->zanode->statusList['ready']        = '運行中';
$lang->zanode->statusList['running']      = '運行中';
$lang->zanode->statusList['suspend']      = '休眠';
$lang->zanode->statusList['offline']      = '下線';
$lang->zanode->statusList['destroy']      = '已銷毀';
$lang->zanode->statusList['shutoff']      = '已關機';
$lang->zanode->statusList['shutodown']    = '已關機';
$lang->zanode->statusList['destroy_fail'] = '銷毀失敗';
$lang->zanode->statusList['wait']         = '初始化中';
$lang->zanode->statusList['online']       = '已上架';

$lang->zanode->initNotice = "保存成功，請初始化執行節點或返回列表。";
$lang->zanode->initButton = "去初始化";

$lang->zanode->init = new stdclass;
$lang->zanode->init->statusTitle   = "服務狀態";
$lang->zanode->init->checkStatus   = "檢測服務狀態";
$lang->zanode->init->not_install   = "未安裝";
$lang->zanode->init->unknown       = "未知";
$lang->zanode->init->not_available = "已安裝，未啟動";
$lang->zanode->init->ready         = "已就緒";
$lang->zanode->init->next          = "下一步";
$lang->zanode->init->button        = "去設置";

$lang->zanode->init->initSuccessNoticeTitle = "服務已就緒，還需兩步即可在執行節點上執行自動化測試：<br/>1、根據%s配置自動化測試運行環境。<br/>2、進行%s";
$lang->zanode->init->initFailNoticeTitle    = "初始化失敗，請查看初始化腳本執行日誌並嘗試以下兩種解決方案：";
$lang->zanode->init->initFailNoticeDesc     = "1、 重新執行腳本 <br/>2、 查看初始化常見問題";

$lang->zanode->init->serviceStatus = [
    "ZenAgent" => 'not_install',
    "ZTF"      => 'not_install',
];
$lang->zanode->init->title          = "初始化執行節點";
$lang->zanode->init->descTitle      = "請根據引導完成執行節點上的初始化: ";
$lang->zanode->init->initDesc       = "- 在執行節點上執行命令：%s %s  <br>- 點擊檢測服務狀態。";$lang->zanode->init->statusTitle    = "服務狀態";

$lang->zanode->tips = '執行節點是由宿主機創建的虛擬機或容器實例，是執行測試任務的測試環境，在執行節點配置自動化測試環境後可以自動執行腳本，結果可以在禪道對應用例執行結果中查看。';
$lang->zanode->scriptTips = '填寫執行節點上自動化測試腳本所在的目錄。';
$lang->zanode->shellTips  = '在執行節點上運行自動化測試腳本前，可以執行自定義的shell命令。';
$lang->zanode->automationTips = '在執行節點上執行測試任務前，需要設置產品對應的執行節點，自動化測試腳本的目錄以及需要執行的自定義Shell命令。';
$lang->zanode->nameUnique     = $lang->zanode->name . '已存在';

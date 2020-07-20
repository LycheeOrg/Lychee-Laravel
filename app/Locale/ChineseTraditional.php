<?php

namespace App\Locale;

final class ChineseTraditional implements LangInterface
{
	public static function code()
	{
		return '繁體中文';
	}

	public static function get_locale()
	{
		$locale = [
			'USERNAME' => '帳號名稱',
			'PASSWORD' => '密碼',
			'ENTER' => '確定',
			'CANCEL' => '取消',
			'SIGN_IN' => '登入',
			'CLOSE' => '關閉',
			'SETTINGS' => '設定',
			'SEARCH' => '搜尋...',
			'MORE' => '更多',

			'USERS' => '使用者',
			'SHARING' => '分享',
			'CHANGE_LOGIN' => '修改登入訊息',
			'CHANGE_SORTING' => '修改排序',
			'SET_DROPBOX' => '設定Dropbox',
			'ABOUT_LYCHEE' => '關於Lychee',
			'DIAGNOSTICS' => '診斷',
			'DIAGNOSTICS_GET_SIZE' => '請求空間使用',
			'LOGS' => '查看日誌',
			'SIGN_OUT' => '登出',
			'UPDATE_AVAILABLE' => '可用更新！',
			'MIGRATION_AVAILABLE' => '可進行轉移!',
			'DEFAULT_LICENSE' => '新上傳的默認許可證:',
			'SET_LICENSE' => '設置許可證',
			'SET_OVERLAY_TYPE' => '設置疊加',
			'SET_MAP_PROVIDER' => '設置OpenStreetMap圖層提供者',

			'SMART_ALBUMS' => '智能相簿',
			'SHARED_ALBUMS' => '共享的相簿',
			'ALBUMS' => '相簿',
			'PHOTOS' => '照片',
			'SEARCH_RESULTS' => '搜索結果',

			'RENAME' => '重新命名',
			'RENAME_ALL' => '重新命名成功',
			'MERGE' => '合併',
			'MERGE_ALL' => '合併成功',
			'MAKE_PUBLIC' => '設為公開',
			'SHARE_ALBUM' => '分享相簿',
			'SHARE_PHOTO' => '分享照片',
			'VISIBILITY_ALBUM' => '相冊隱私設定',
			'VISIBILITY_PHOTO' => '照片隱私設定',
			'DOWNLOAD_ALBUM' => '下載相簿',
			'ABOUT_ALBUM' => '關於相簿',
			'DELETE_ALBUM' => '刪除相簿',
			'MOVE_ALBUM' => '移動相簿',
			'FULLSCREEN_ENTER' => '全螢幕模式',
			'FULLSCREEN_EXIT' => '結束全螢幕模式',

			'DELETE_ALBUM_QUESTION' => '刪除相簿和照片',
			'KEEP_ALBUM' => '保留相簿',
			'DELETE_ALBUM_CONFIRMATION_1' => '確定要刪除相簿',
			'DELETE_ALBUM_CONFIRMATION_2' => '以及相簿內包含的所有照片？此動作無法還原！',

			'DELETE_ALBUMS_QUESTION' => '删刪除相簿和照片',
			'KEEP_ALBUMS' => '保留相簿',
			'DELETE_ALBUMS_CONFIRMATION_1' => '確定要刪除全部照片',
			'DELETE_ALBUMS_CONFIRMATION_2' => '選取的相冊和其中的所有照片？此動作無法還原！',

			'DELETE_UNSORTED_CONFIRM' => '確定刪除\'未分類\'的所有照片？<br>此動作無法還原！',
			'CLEAR_UNSORTED' => '清除未分類',
			'KEEP_UNSORTED' => '保留未分類',

			'EDIT_SHARING' => '編輯共享',
			'MAKE_PRIVATE' => '設為私人',

			'CLOSE_ALBUM' => '關閉相簿',
			'CLOSE_PHOTO' => '關閉照片',
			'CLOSE_MAP' => '關閉地圖',

			'ADD' => '添加',
			'MOVE' => '移動',
			'MOVE_ALL' => '移動已選項目',
			'DUPLICATE' => '創建副本',
			'DUPLICATE_ALL' => '複製已選項目',
			'COPY_TO' => '複製到...',
			'COPY_ALL_TO' => '複製到...',
			'DELETE' => '刪除',
			'DELETE_ALL' => '删除已選項目',
			'DOWNLOAD' => '下載',
			'DOWNLOAD_ALL' => '下載已選項目',
			'UPLOAD_PHOTO' => '上傳照片',
			'IMPORT_LINK' => '從連結導入',
			'IMPORT_DROPBOX' => '從Dropbox導入',
			'IMPORT_SERVER' => '從伺服器導入',
			'NEW_ALBUM' => '創建新相簿',

			'TITLE_NEW_ALBUM' => '輸入相簿標題：',
			'UNTITLED' => '未命名',
			'UNSORTED' => '未分類',
			'STARRED' => '我的最愛',
			'RECENT' => '最新',
			'PUBLIC' => '公開',
			'NUM_PHOTOS' => '照片',

			'CREATE_ALBUM' => '創建相簿',

			'STAR_PHOTO' => '加入我的最愛',
			'STAR' => '我的最愛',
			'STAR_ALL' => '將已選的標記為收藏夾',
			'TAGS' => '標籤',
			'TAGS_ALL' => '大量標籤',
			'UNSTAR_PHOTO' => '從我的最愛中移除',

			'FULL_PHOTO' => '打開原圖',
			'ABOUT_PHOTO' => '照片資訊',
			'DISPLAY_FULL_MAP' => '地圖',
			'DIRECT_LINK' => '外部連結',
			'DIRECT_LINKS' => '內部連結',

			'ALBUM_ABOUT' => '關於',
			'ALBUM_BASICS' => '基本資訊',
			'ALBUM_TITLE' => '標題',
			'ALBUM_NEW_TITLE' => '輸入新的相簿標題：',
			'ALBUMS_NEW_TITLE_1' => '設定標題為',
			'ALBUMS_NEW_TITLE_2' => '已選擇的所有相簿：',
			'ALBUM_SET_TITLE' => '設定標題',
			'ALBUM_DESCRIPTION' => '描述',
			'ALBUM_NEW_DESCRIPTION' => '輸入新的相簿描述：',
			'ALBUM_SET_DESCRIPTION' => '編輯描述',
			'ALBUM_ALBUM' => '相簿',
			'ALBUM_CREATED' => '創建時間',
			'ALBUM_IMAGES' => '圖片資訊',
			'ALBUM_VIDEOS' => '影片',
			'ALBUM_SUBALBUMS' => '子相簿',
			'ALBUM_SHARING' => '共享',
			'ALBUM_SHR_YES' => '是',
			'ALBUM_SHR_NO' => '否',
			'ALBUM_PUBLIC' => '公開',
			'ALBUM_PUBLIC_EXPL' => '相簿可以被其他人查看，但要遵守以下限制。',
			'ALBUM_FULL' => '原版',
			'ALBUM_FULL_EXPL' => '提供全分辨率圖片。',
			'ALBUM_HIDDEN' => '隱藏',
			'ALBUM_HIDDEN_EXPL' => '只有使用外部連結才能查看。',
			'ALBUM_DOWNLOADABLE' => '下載',
			'ALBUM_DOWNLOADABLE_EXPL' => '訪客可己下載該相簿',
			'ALBUM_SHARE_BUTTON_VISIBLE' => '分享按鈕是可見的',
			'ALBUM_SHARE_BUTTON_VISIBLE_EXPL' => '顯示社交媒體分享鏈接。',
			'ALBUM_PASSWORD' => '密碼',
			'ALBUM_PASSWORD_PROT' => '密碼保護',
			'ALBUM_PASSWORD_PROT_EXPL' => '只有輸入正確的密碼才可以查看相簿。',
			'ALBUM_PASSWORD_REQUIRED' => '此相簿設有密碼保護。請輸入密碼：',
			'ALBUM_MERGE_1' => '你確定要合併相簿',
			'ALBUM_MERGE_2' => '到該相簿',
			'ALBUMS_MERGE' => '你確定要合併所有已選擇的相簿到該相簿?',
			'MERGE_ALBUM' => '合併相簿',
			'DONT_MERGE' => '不要合併',
			'ALBUM_MOVE_1' => '您確定要移動相簿',
			'ALBUM_MOVE_2' => '到該相簿',
			'ALBUMS_MOVE' => '你確定要合併所有已選擇的相簿到該相簿?',
			'MOVE_ALBUMS' => '相簿移動',
			'NOT_MOVE_ALBUMS' => '不要移動',
			'ROOT' => '相簿',
			'ALBUM_REUSE' => '重複利用',
			'ALBUM_LICENSE' => '許可證',
			'ALBUM_SET_LICENSE' => '設定許可證',
			'ALBUM_LICENSE_HELP' => '需要選擇幫助嗎？',
			'ALBUM_LICENSE_NONE' => '不須',
			'ALBUM_RESERVED' => '版權所有',

			'PHOTO_ABOUT' => '關於',
			'PHOTO_BASICS' => '基本資訊',
			'PHOTO_TITLE' => '標題',
			'PHOTO_NEW_TITLE' => '輸入新的相片標題：',
			'PHOTO_SET_TITLE' => '設定標題',
			'PHOTO_UPLOADED' => '已上傳',
			'PHOTO_DESCRIPTION' => '描述',
			'PHOTO_NEW_DESCRIPTION' => '輸入新的照片描述',
			'PHOTO_SET_DESCRIPTION' => '編輯描述',
			'PHOTO_NEW_LICENSE' => '新增許可證',
			'PHOTO_SET_LICENSE' => '設定許可證',
			'PHOTO_LICENSE' => '許可證',
			'PHOTO_REUSE' => '重複利用',
			'PHOTO_LICENSE_NONE' => '無',
			'PHOTO_RESERVED' => '版權所有',
			'PHOTO_LATITUDE' => '緯度',
			'PHOTO_LONGITUDE' => '經度',
			'PHOTO_ALTITUDE' => '高度',
			'PHOTO_IMGDIRECTION' => '方向',
			'PHOTO_LOCATION' => '位置',
			'PHOTO_IMAGE' => '照片資訊',
			'PHOTO_VIDEO' => '影片',
			'PHOTO_SIZE' => '大小',
			'PHOTO_FORMAT' => '格式',
			'PHOTO_RESOLUTION' => '解析度',
			'PHOTO_DURATION' => '持續時間',
			'PHOTO_FPS' => '影格速率',
			'PHOTO_TAGS' => '標籤',
			'PHOTO_NOTAGS' => '無標籤',
			'PHOTO_NEW_TAGS' => '為該照片添加標籤(用逗號分隔)：',
			'PHOTO_NEW_TAGS_1' => '大量標籤',
			'PHOTO_NEW_TAGS_2' => '標籤已選照片(已存在的標籤會被覆蓋；用逗號分隔)：',
			'PHOTO_SET_TAGS' => '設定標籤',
			'PHOTO_CAMERA' => '相機資訊',
			'PHOTO_CAPTURED' => '拍攝時間',
			'PHOTO_MAKE' => '設備',
			'PHOTO_TYPE' => '類型/型號',
			'PHOTO_LENS' => '鏡片',
			'PHOTO_SHUTTER' => '快門速度',
			'PHOTO_APERTURE' => '光圈',
			'PHOTO_FOCAL' => '焦距',
			'PHOTO_ISO' => 'ISO感光度',
			'PHOTO_SHARING' => '共享',
			'PHOTO_SHR_PLUBLIC' => '公開',
			'PHOTO_SHR_ALB' => '是 (相簿)',
			'PHOTO_SHR_PHT' => '是 (照片)',
			'PHOTO_SHR_NO' => '否',
			'PHOTO_DELETE' => '刪除照片',
			'PHOTO_KEEP' => '保留照片',
			'PHOTO_DELETE_1' => '是否要刪除照片',
			'PHOTO_DELETE_2' => '？此動作無法還原！',
			'PHOTO_DELETE_ALL_1' => '是否要刪除除所有',
			'PHOTO_DELETE_ALL_2' => '已選擇的照片？此動作無法還原！',
			'PHOTOS_NEW_TITLE_1' => '批量編輯照片標題',
			'PHOTOS_NEW_TITLE_2' => '已選的照片：',
			'PHOTO_MAKE_PRIVATE_ALBUM' => '此照片位於公開相簿中。編輯所在相冊的隱私設定，將其設置為公開或私有。',
			'PHOTO_SHOW_ALBUM' => '顯示相簿',
			'PHOTO_PUBLIC' => '公開',
			'PHOTO_PUBLIC_EXPL' => '他人可以查看照片，但受以下限制',
			'PHOTO_FULL' => '原始',
			'PHOTO_FULL_EXPL' => '完整解析度照片可用',
			'PHOTO_HIDDEN' => '隱藏',
			'PHOTO_HIDDEN_EXPL' => '只有具有直接鏈接的人才能查看此照片。',
			'PHOTO_DOWNLOADABLE' => '允許下載',
			'PHOTO_DOWNLOADABLE_EXPL' => '您畫廊的訪客可以下載這張照片。',
			'PHOTO_SHARE_BUTTON_VISIBLE' => '分享按鈕可用',
			'PHOTO_SHARE_BUTTON_VISIBLE_EXPL' => '顯示社交媒體分享鏈接',
			'PHOTO_PASSWORD_PROT' => '密碼保護',
			'PHOTO_PASSWORD_PROT_EXPL' => '僅允許有效密碼檢視照片',
			'PHOTO_EDIT_SHARING_TEXT' => '此照片的共享屬性將更改為以下內容:',
			'PHOTO_NO_EDIT_SHARING_TEXT' => '由於此照片位於公開相簿中，因此它會繼承該相冊的公開範圍設置。 下面顯示了它的當前可見性，僅供參考。',
			'PHOTO_EDIT_GLOBAL_SHARING_TEXT' => '可以使用全局Lychee設置微調這張照片的可見性。 下面顯示了它的當前可見性，僅供參考。',
			'PHOTO_SHARING_CONFIRM' => '保存',

			'LOADING' => '載入中',
			'ERROR' => '錯誤',
			'ERROR_TEXT' => '噢，似乎出了一些問題。請重整頁面後再試一次！',
			'ERROR_DB_1' => '無法連接數據庫，訪問被拒絕。請仔細檢查主機，用戶名和密碼，確保允許從當前位置訪問。',
			'ERROR_DB_2' => '無法創建數據庫。請仔細檢查主機，用戶名和密碼，確保該擁有權在數據庫中添加和修改內容。',
			'ERROR_CONFIG_FILE' => "無法保存設置。<b>'data/'</b> 拒絕訪問。請為其他用戶設置 <b>'data/'</b> 和 <b>'uploads/'</b> 目錄的讀寫權限。查看自述文件以獲取更多信息。",
			'ERROR_UNKNOWN' => '發生未知問題！請再試一次，檢查您的安裝和服務器。請查看自述文件以獲取更多信息。',
			'ERROR_LOGIN' => '無法保存登錄信息。請用另一個用戶名和密碼再試一次！',
			'ERROR_MAP_DEACTIVATED' => '地圖功能已被設為停用。',
			'ERROR_SEARCH_DEACTIVATED' => '搜索功能已在設為停用。',
			'SUCCESS' => '好',
			'RETRY' => '重試',

			'SETTINGS_SUCCESS_LOGIN' => '登錄信息已更新',
			'SETTINGS_SUCCESS_SORT' => '排序順序已更新。',
			'SETTINGS_SUCCESS_DROPBOX' => 'Dropbox密鑰已更新',
			'SETTINGS_SUCCESS_LANG' => '語言已更新',
			'SETTINGS_SUCCESS_LAYOUT' => '佈局已更新',
			'SETTINGS_SUCCESS_IMAGE_OVERLAY' => 'EXIF覆蓋設置已更新',
			'SETTINGS_SUCCESS_PUBLIC_SEARCH' => '公開搜尋已更新',
			'SETTINGS_SUCCESS_LICENSE' => '默認許可證已更新',
			'SETTINGS_SUCCESS_MAP_DISPLAY' => '地圖顯示設置已更新',
			'SETTINGS_SUCCESS_MAP_DISPLAY_PUBLIC' => '公開相簿的地圖顯示設置已更新',
			'SETTINGS_SUCCESS_MAP_PROVIDER' => '地圖提供商設置已更新',

			'DB_INFO_TITLE' => '請輸入數據庫信息',
			'DB_INFO_HOST' => '數據庫主機（選填）',
			'DB_INFO_USER' => '數據庫用戶名',
			'DB_INFO_PASSWORD' => '數據庫密碼',
			'DB_INFO_TEXT' => 'Lychee將自行創建數據庫。如果需要，可以使用現有數據庫',
			'DB_NAME' => '數據庫名稱（選填）',
			'DB_PREFIX' => '表前綴（選填）',
			'DB_CONNECT' => '連接',

			'LOGIN_TITLE' => '輸入管理員用戶名和密碼：',
			'LOGIN_USERNAME' => '新用戶名',
			'LOGIN_PASSWORD' => '新密碼',
			'LOGIN_PASSWORD_CONFIRM' => '確認密碼',
			'LOGIN_CREATE' => '創建',

			'PASSWORD_TITLE' => '當前密碼',
			'USERNAME_CURRENT' => '當前用戶名',
			'PASSWORD_CURRENT' => '當前密碼',
			'PASSWORD_TEXT' => '用戶名和密碼將被修改為：',
			'PASSWORD_CHANGE' => '修改登入訊息',

			'EDIT_SHARING_TITLE' => '編輯共享',
			'EDIT_SHARING_TEXT' => '相冊的共享屬性將被修改為：',
			'SHARE_ALBUM_TEXT' => '該相冊的共享屬性：',
			'ALBUM_SHARING_CONFIRM' => '保存',

			'SORT_ALBUM_BY_1' => '相簿排序',
			'SORT_ALBUM_BY_2' => '在一個',
			'SORT_ALBUM_BY_3' => '排序',

			'SORT_ALBUM_SELECT_1' => '創建時間',
			'SORT_ALBUM_SELECT_2' => '標題',
			'SORT_ALBUM_SELECT_3' => '描述',
			'SORT_ALBUM_SELECT_4' => '公开',
			'SORT_ALBUM_SELECT_5' => '最新',
			'SORT_ALBUM_SELECT_6' => '最老',

			'SORT_PHOTO_BY_1' => '照片排序',
			'SORT_PHOTO_BY_2' => '在一個',
			'SORT_PHOTO_BY_3' => '排序',

			'SORT_PHOTO_SELECT_1' => '發佈時間',
			'SORT_PHOTO_SELECT_2' => '創建時間',
			'SORT_PHOTO_SELECT_3' => '標題',
			'SORT_PHOTO_SELECT_4' => '描述',
			'SORT_PHOTO_SELECT_5' => '公開',
			'SORT_PHOTO_SELECT_6' => '喜歡',
			'SORT_PHOTO_SELECT_7' => '照片格式',

			'SORT_ASCENDING' => '升序',
			'SORT_DESCENDING' => '降序',
			'SORT_CHANGE' => '修改排序',

			'DROPBOX_TITLE' => '設置Dropbox私鑰',
			'DROPBOX_TEXT' => "要從Dropbox導入照片，需要一個有效的應用私鑰，請到<a href='https://www.dropbox.com/developers/apps/create'>官網獲取</a>。輸入你自己生成的私鑰：",

			'LANG_TEXT' => '將Lychee語言更改為：',
			'LANG_TITLE' => '改變語言',
			'PUBLIC_SEARCH_TEXT' => '允許公共搜索:',
			'IMAGE_OVERLAY_TEXT' => '默認情況下顯示數據疊加：',
			'OVERLAY_TYPE' => '圖像疊加中要使用的數據:',
			'OVERLAY_EXIF' => '照片EXIF數據',
			'OVERLAY_DESCRIPTION' => '照片說明',
			'OVERLAY_DATE' => '拍攝日期',
			'MAP_DISPLAY_TEXT' => '啟用地圖（由OpenStreetMap提供）:',
			'MAP_DISPLAY_PUBLIC_TEXT' => '為公開相冊啟用地圖（由OpenStreetMap提供）:',
			'MAP_PROVIDER' => '地圖的提供者:',
			'MAP_PROVIDER_WIKIMEDIA' => '維基媒體',
			'MAP_PROVIDER_OSM_ORG' => 'OpenStreetMap.org (無 HiDPI)',
			'MAP_PROVIDER_OSM_DE' => 'OpenStreetMap.de (無 HiDPI)',
			'MAP_PROVIDER_OSM_FR' => 'OpenStreetMap.fr (無 HiDPI)',
			'MAP_PROVIDER_RRZE' => '德國埃爾蘭根大學 (只有 HiDPI)',
			'MAP_INCLUDE_SUBALBUMS_TEXT' => '在地圖上包括子相冊的照片:',
			'LOCATION_DECODING' => '將GPS數據解碼為位置名稱',
			'LOCATION_SHOW' => '顯示地點名稱',
			'LOCATION_SHOW_PUBLIC' => '顯示公共模式的位置名稱',
			'LAYOUT_TYPE' => '照片佈局:',
			'LAYOUT_SQUARES' => '方形縮略圖',
			'LAYOUT_JUSTIFIED' => '有方面，有道理',
			'LAYOUT_UNJUSTIFIED' => '有方面，沒有道理',
			'SET_LAYOUT' => '變更版面',

			'VIEW_NO_RESULT' => '無結果',
			'VIEW_NO_PUBLIC_ALBUMS' => '沒有公開相簿',
			'VIEW_NO_CONFIGURATION' => '没有配置',
			'VIEW_PHOTO_NOT_FOUND' => '没找到照片',

			'NO_TAGS' => '沒有標籤',

			'UPLOAD_MANAGE_NEW_PHOTOS' => '現在可以管理你的新照片了',
			'UPLOAD_COMPLETE' => '上傳完成',
			'UPLOAD_COMPLETE_FAILED' => '有幾個照片上傳失敗了',
			'UPLOAD_IMPORTING' => '導入',
			'UPLOAD_IMPORTING_URL' => '導入 URL',
			'UPLOAD_UPLOADING' => '上傳中',
			'UPLOAD_FINISHED' => '已完成',
			'UPLOAD_PROCESSING' => '處理中',
			'UPLOAD_FAILED' => '失敗',
			'UPLOAD_FAILED_ERROR' => '上傳失敗。服務器傳回了一個錯誤！',
			'UPLOAD_FAILED_WARNING' => '上傳失敗。服務器傳回了一個警告！',
			'UPLOAD_SKIPPED' => '已跳過',
			'UPLOAD_ERROR_CONSOLE' => '請查看瀏覽器控制台獲取詳細信息。',
			'UPLOAD_UNKNOWN' => '服務器返回未知響應。請查看瀏覽器控制台獲取詳細信息。',
			'UPLOAD_ERROR_UNKNOWN' => '上傳失敗。服務器回傳了一個未知錯誤！',
			'UPLOAD_IN_PROGRESS' => 'Lychee當前正在上傳！',
			'UPLOAD_IMPORT_WARN_ERR' => '導入成功，但返回了的警告或錯誤。請查看日誌（設置->顯示日誌）以獲取詳細信息。',
			'UPLOAD_IMPORT_COMPLETE' => '導入完成',
			'UPLOAD_IMPORT_INSTR' => '輸入照片鏈接直接導入：',
			'UPLOAD_IMPORT' => '導入',
			'UPLOAD_IMPORT_SERVER' => '從服務器導入',
			'UPLOAD_IMPORT_SERVER_FOLD' => '文件夾中沒有可讀的文件。請查看日誌（設置->顯示日誌）以獲取詳細信息。',
			'UPLOAD_IMPORT_SERVER_INSTR' => '此操作將導入位於以下目錄中的所有照片，文件夾和子文件夾。',
			'UPLOAD_ABSOLUTE_PATH' => '絕對路徑',
			'UPLOAD_IMPORT_SERVER_EMPT' => '無法導入空文件夾！',
			'UPLOAD_IMPORT_DELETE_ORIGINALS' => '刪除原件',
			'UPLOAD_IMPORT_DELETE_ORIGINALS_EXPL' => '如果可能，原始文件將在導入後刪除。',
			'UPLOAD_IMPORT_LOW_MEMORY' => '內存不足！',
			'UPLOAD_IMPORT_LOW_MEMORY_EXPL' => '服務器上的導入過程已接近內存限制，並可能最終被提前終止。',
			'UPLOAD_WARNING' => '警告',
			'UPLOAD_IMPORT_NOT_A_DIRECTORY' => '給定的路徑不是可讀目錄！',
			'UPLOAD_IMPORT_PATH_RESERVED' => '給定的路徑是Lychee的保留路徑！',
			'UPLOAD_IMPORT_UNREADABLE' => '無法讀取文件！',
			'UPLOAD_IMPORT_FAILED' => '無法導入文件！',
			'UPLOAD_IMPORT_UNSUPPORTED' => '不支援的文件類型！',
			'UPLOAD_IMPORT_ALBUM_FAILED' => '無法創建相簿！',

			'ABOUT_SUBTITLE' => 'Lychee自主託管的照片管理程序',
			'ABOUT_DESCRIPTION' => '是一個免費的照片管理工具，可在您的伺服器或網站空間上運行。安裝僅需幾秒鐘。<br>上傳，管理和分享照片(例如從本機應用程序)。<br>Lychee提供您所需的一切，所有照片均安全存儲。',
			'FOOTER_COPYRIGHT' => '本網站的照片均受版權所有',
			'HOSTED_WITH_LYCHEE' => '使用Lychee託管照片',

			'URL_COPY_TO_CLIPBOARD' => '複製到剪貼板',
			'URL_COPIED_TO_CLIPBOARD' => '複製到剪貼板的URL！',
			'PHOTO_DIRECT_LINKS_TO_IMAGES' => '指向圖像文件的直接鏈接：',
			'PHOTO_MEDIUM' => 'Medium',
			'PHOTO_MEDIUM_HIDPI' => 'Medium HiDPI',
			'PHOTO_SMALL' => 'Thumb',
			'PHOTO_SMALL_HIDPI' => 'Thumb HiDPI',
			'PHOTO_THUMB' => 'Square thumb',
			'PHOTO_THUMB_HIDPI' => 'Square thumb HiDPI',
			'PHOTO_LIVE_VIDEO' => '實時照片的視頻部分',
			'PHOTO_VIEW' => 'Lychee照片瀏覽：',

			'PHOTO_EDIT_ROTATECWISE' => '順時針旋轉',
			'PHOTO_EDIT_ROTATECCWISE' => '逆時針旋轉',
		];

		return $locale;
	}
}

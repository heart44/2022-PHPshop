<?php
function getRandomFileNm($fileName) {
    return gen_uuid_v4() . "." . getExt($fileName);
}

function getExt($fileName) {
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function gen_uuid_v4() { 
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x'
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0x0fff) | 0x4000
        , mt_rand(0, 0x3fff) | 0x8000
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff) 
    ); 
}

function rmdir_all($delete_path) {
	if(!is_dir($delete_path)) { return; }

	$dirs = dir($delete_path);

	while(false !== ($entry = $dirs->read())) {
		// 디렉토리의 내용을 하나씩 읽는다.
		if(($entry != '.') && ($entry != '..')) {
			// 디렉토리의 내용중 현재폴더, 상위폴더가 아니면 (즉 파일 및 디렉토리)            
			if(is_dir($delete_path . '/' . $entry)) {
				//디렉토리이면 재귀호출로 다시 삭제 시작.
				rmdir_all($delete_path.'/'.$entry);
			} else {
				//해당 파일 삭제
				@unlink($delete_path.'/'.$entry);
			}
		}
	}

	$dirs->close();

	// 최종 디렉토리 삭제
	@rmdir($delete_path);
}
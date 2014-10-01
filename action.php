<?php
require_once( '../../php/rtorrent.php' );

$g_nFSS_Status = 1;
$g_sFSS_Error = "";
$g_sFSS_Msg = "";
$g_nFSS_nbSaved = 0;
$g_nFSS_nbFailed = 0;

$req = new rXMLRPCRequest( array(
            new rXMLRPCCommand("download_list")
));

if($req->run() && !$req->fault)
{
	if (is_array($req->val) && count($req->val))
	{
		foreach ($req->val as $hash)
		{
			$reqSave = new rXMLRPCRequest( array(
					new rXMLRPCCommand("d.save_full_session", $hash)
			));
			if($reqSave->run() && !$reqSave->fault)
			{
				$g_nFSS_nbSaved++;
			}
			else
			{
				$g_nFSS_nbFailed;
			}
		}
		
		if (($g_nFSS_nbFailed > 0) && ($g_nFSS_nbSaved <= 0))
		{
			$g_nFSS_Status = 0;
			$g_sFSS_Error = "All $g_nFSS_nbFailed torrents failed to save";
		}
		else
		{
			$g_nFSS_Status = 1;
			$g_sFSS_Msg = "$g_nFSS_nbSaved saved, $g_nFSS_nbFailed failed";
		}
	}
}
else
{
	$g_nFSS_Status = 0;
	$g_sFSS_Error = "Error when getting full hash list";
}

cachedEcho('{"status":'.$g_nFSS_Status.',"error":"'.$g_sFSS_Error.'","msg":"'.$g_sFSS_Msg.'"}',"application/json");
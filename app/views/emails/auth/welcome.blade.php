<!DOCTYPE html>
<html>
<head>
	<title>Verify your KeepUsUp account</title>
	<link rel="important stylesheet" href="chrome://messagebody/skin/messageBody.css">
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background-color: #555555; margin: 0; padding: 0; color: #555555;">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" height="100%" bgcolor="#555555" id="main">
        <tr>
            <td align="center" valign="top" style="font-size: 11px; font-family: Arial, Verdana, sans-serif;">
                <table width="620" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr id="top">
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="text-align: left; padding: 15px 0px 0px 20px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 3px;">
                            <table border="0" cellpadding="0" cellspacing="0" id="outline" style="border: 1px solid #6c6c6c; width: 100%; text-align: left;" bgcolor="#ffffff">
                                <tr>
                                    <td>
                                        <table cellpadding="20" cellspacing="0" border="0" height="100" style="border-bottom: 20px solid #0099d9; width: 100%; height: 100px;" bgcolor="#474747">
                                            <tr>
                                                <td valign="middle"><a href="http://dev.keepusup.com/">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="KeepUsUp" border="0"/></a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">
                                        <table cellpadding="20" cellspacing="0" border="0" style="width: 100%; min-height: 350px; font-family: Arial, Verdana, sans-serif;">
                                            <tr>
                                                <!-- start body copy -->
                                                <td valign="top" width="450">
                                                    <h1 style="font-family: Arial, Verdana, sans-serif; font-size: 22px; color: #555555;">Verify your KeepUsUp account and set up your KeepUsUp ID.</h1>
                                                    <p style="color: #555555; font-size: 12px; line-height: 20px;">
                                                        To verify  <a href="mailto:{{{ $email }}}" style="color: #555555; font-weight: bold; text-decoration: none;"><span>{{{ $email }}}</span></a>  as your KeepUsUp ID, click this link:
                                                        <br />
                                                        <br />
                                                        <a href="{{ URL::to('users') }}/{{ $userId }}/activate/{{ urlencode($activationCode) }}" style="outline: none; color: #00aeef; font-weight: bold; text-decoration: none;">{{ URL::to('users') }}/{{ $userId }}/activate/{{ urlencode($activationCode) }}</a>
                                                        <br />
                                                        <br />
                                                        Your KeepUsUp ID gives you access to many great products by KeepUsUp, to make you more productive and more capable every day. 
                                                        <br />
                                                        <br />
                                                    </p>
                                                </td>
                                                <td valign="top" align="center" width="169" style="border-left: 1px solid #cccccc; white-space: nowrap;">
                                                    <p style="color: #555555; font-size: 12px; line-height: 20px;">
                                                        <strong>KeepUsUp Products:</strong>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr bgcolor="#edeff0" width="100%">
                                    <td align="center" valign="top" style="font-size: 11px; font-family: Arial, Verdana, sans-serif; color: #666666;">
                                        <table cellspacing="0" border="0" cellpadding="20" width="100%" style="border-top: 1px solid #c0c0c0;">
                                            <tr>
                                                <td align="left" valign="middle" style="font-size: 11px; line-height: 16px; font-family: Arial, Verdana, sans-serif; color: #666666;">
                                                    <strong>Questions?</strong> <a href="http://dev.keepusup.com/" style="outline: none; color: #00aeef; font-weight: bold; text-decoration: none;">Contact Customer Support</a>.<br />
                                                    Please do not reply to this email. (Unless you want some very nice computers to read it.)<br />
                                                    <br />
                                                    &copy; KeepUsUp Inc</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- end outline table -->
                            <br />
                            <br />
                        </td>
                    </tr>
                </table>
                <!-- end holder -->
            </td>
        </tr>
    </table>
    <!-- end main table -->
</body>
</html>

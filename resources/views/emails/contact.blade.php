
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>MyVesu!</title>
</head>
<body>
    <table class="main" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="content-wrap">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-block" style="text-align:center;">
                           MyVesu!
                        </td>
                    </tr>
                    <tr style="text-align:center">
                        <td class="content-block">{{$data['subject']}}</td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-block" style="text-align:center;">
                            Username : {{$data['username']}}
                        </td>
                    </tr>
                    <tr>
                        <td class="content-block" style="text-align:center;">
                            Email : {{$data['email']}}
                        </td>
                    </tr>
                    <tr>
                        <td class="content-block" style="text-align:center;">
                            Message : {{$data['message']}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نتيجة الدفع</title>
    <style>
        body { text-align:center; font-family:Tahoma; margin-top:100px; }
        .success { color:green; font-size:24px; }
        .failed { color:red; font-size:24px; }
    </style>
</head>
<body>
@if($status == 'success')
    <h2 class="success">✅ تم الدفع بنجاح</h2>
@elseif($status == 'failed')
    <h2 class="failed">❌ فشل الدفع</h2>
@else
    <h2 class="failed">⚠️ حدث خطأ أثناء التحقق</h2>
@endif

<p><strong>رقم الطلب:</strong> {{ $order ?? 'غير متاح' }}</p>
<p><strong>المبلغ:</strong> {{ $amount ?? '0' }} جنيه</p>
<p><strong>رقم العملية:</strong> {{ $transaction_id ?? 'غير متاح' }}</p>

@if(isset($message))
    <p>{{ $message }}</p>
@endif
</body>
</html>

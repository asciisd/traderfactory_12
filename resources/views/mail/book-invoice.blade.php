@component('mail::message')
# فاتورة شراء كتاب: {{ $book->name }}

شكراً لشرائك كتاب {{ $book->name }}. فيما يلي تفاصيل طلبك:

@component('mail::table')
    | البيان       | التفاصيل         |
    | :------------: | :----------------: |
    | رقم الطلب    |{{ $order['id'] }} |
    | المبلغ       |{{ $order['amount'] }} {{ $order['currency'] }} |
    | حالة الدفع   |{{ $order['paymentStatus'] }} |
    | رقم المعاملة |{{ $order['orderReference'] }} |
    | طريقة الدفع  |{{ $order['cardBrand'] }} |
    | تاريخ الطلب  |{{ $order['created_at']->format('Y-m-d H:i') }} |
@endcomponent

يمكنك تحميل الكتاب من خلال الرابط أدناه:

@component('mail::button', ['url' => route('books.download.page', ['book' => $book->id])])
    تحميل الكتاب
@endcomponent

شكراً لاختيارك تريدر فاكتوري.
@endcomponent

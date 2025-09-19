export interface Orders {
    data: Order[];
}

export interface Order {
    id: number;
    order_type: string;
    order_title: string;
    total: number;
    sub_total: number;
    currency: string;
    type: string;
    status: OrderStatus;
    created_at: string;
    href: string;
    is_book: boolean;
    is_downloadable: boolean;
    download_url: string;
}

interface OrderStatus {
    bg_color: string
    description: string
    id: string
    name: string
    style: string
    text_color: string
}

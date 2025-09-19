import { usePage } from '@inertiajs/vue3';

const page = usePage();
export function egyCurrencyFormat(amount: number): string {
    if (!amount) {
        amount = 0;
    }

    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'EGP',
    }).format(amount);
}

export function formattedDate(created_at: string): string {
    const createdAtDate = new Date(created_at);

    // @ts-expect-error page is not defined as a type
    return createdAtDate.toLocaleString(page.props.locale, { year: 'numeric', month: 'short', day: 'numeric' });
}

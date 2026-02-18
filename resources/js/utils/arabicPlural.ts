export function arabicPlural(word: string, count: number): string {
    const forms: Record<string, [string, string, string]> = {
        'دقيقة': ['دقيقة', 'دقيقتان', 'دقائق'],
        'درس': ['درس', 'درسان', 'دروس'],
    };
    const [singular, dual, plural] = forms[word] || [word, word, word];

    let counter = Number(count);

    if (counter === 0) return `0 ${plural}`;
    if (counter === 1) return `1 ${singular}`;
    if (counter === 2) return dual;
    if (counter >= 3 && counter <= 10) return `${counter} ${plural}`;
    if (counter >= 11) return `${counter} ${singular}`;
    return `${counter} ${word}`;
}

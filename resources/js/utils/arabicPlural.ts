export function arabicPlural(word: string, count: number): string {
    const forms: Record<string, [string, string, string]> = {
        'دقيقة': ['دقيقة', 'دقيقتان', 'دقائق'],
        'درس': ['درس', 'درسان', 'دروس'],
    };
    const [singular, dual, plural] = forms[word] || [word, word, word];

    if (count === 0) return `0 ${plural}`;
    if (count === 1) return `1 ${singular}`;
    if (count === 2) return dual;
    if (count >= 3 && count <= 10) return `${count} ${plural}`;
    if (count >= 11) return `${count} ${singular}`;
    return `${count} ${word}`;
}

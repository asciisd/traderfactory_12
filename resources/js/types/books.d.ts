export interface Books {
    data: Book[];
}

export interface Book {
    id: number;
    name: string;
    description: string;
    imageSrc: string;
    fileSrc: string;
    fileCta: string;
    imageAlt: string;
    price: number;
    isOwned: boolean;
    downloadUrl: string;
}

/**
 * @typedef {Object} Photo
 * @property {number} id
 * @property {string} title
 * @property {string} ceremony
 * @property {string} date
 * @property {'Ceremony'|'Department'|'Awards'} category
 * @property {string} year
 * @property {string} image
 * @property {string} description
 */

/** @type {Photo[]} */
export const photos = [
    {
        id: 1,
        title: "Class of 2024 Celebration",
        ceremony: "2024 Spring Graduation Ceremony",
        date: "July 15, 2024",
        category: "Ceremony",
        year: "2024",
        image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&h=600&fit=crop&crop=face",
        description: "Celebrating the achievements of our 2024 graduates",
    },
    {
        id: 2,
        title: "Valedictorian Speech",
        ceremony: "2024 Spring Graduation Ceremony",
        date: "July 15, 2024",
        category: "Ceremony",
        year: "2024",
        image: "https://images.unsplash.com/photo-1627556704281-ac4e786e662d?w=600&h=600&fit=crop&crop=face",
        description: "Our valedictorian delivering an inspiring speech",
    },
    {
        id: 3,
        title: "Engineering Department Graduates",
        ceremony: "2024 Engineering Graduation",
        date: "July 16, 2024",
        category: "Department",
        departmentName: "Engineering",
        departmentSlug: "engineering",
        year: "2024",
        image: "https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=600&h=600&fit=crop&crop=face",
        description: "Engineering graduates celebrating their achievements",
    },
    {
        id: 4,
        title: "Academic Excellence Awards",
        ceremony: "Academic Awards Ceremony 2024",
        date: "July 17, 2024",
        category: "Awards",
        year: "2024",
        image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=600&fit=crop&crop=face",
        description: "Recognizing outstanding academic performance",
    },
    {
        id: 5,
        title: "Medical School Graduation",
        ceremony: "2024 Medical School Ceremony",
        date: "July 18, 2024",
        category: "Department",
        departmentName: "Medicine & Health Sciences",
        departmentSlug: "medicine-health-sciences",
        year: "2024",
        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=600&h=600&fit=crop&crop=face",
        description: "New doctors taking the Hippocratic oath",
    },
    {
        id: 6,
        title: "Computer Science Graduates",
        ceremony: "2024 CS Department Ceremony",
        date: "July 19, 2024",
        category: "Department",
        departmentName: "Computer Science & IT",
        departmentSlug: "computer-science-it",
        year: "2024",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=600&fit=crop&crop=face",
        description: "Computer Science graduates ready for the tech world",
    },
    {
        id: 7,
        title: "Business Administration Celebration",
        ceremony: "2024 Business School Graduation",
        date: "July 20, 2024",
        category: "Department",
        departmentName: "Business & Management",
        departmentSlug: "business-management",
        year: "2024",
        image: "https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&h=600&fit=crop&crop=face",
        description: "Future business leaders celebrating their achievements",
    },
    {
        id: 8,
        title: "International Students Recognition",
        ceremony: "2024 International Ceremony",
        date: "July 21, 2024",
        category: "Awards",
        year: "2024",
        image: "https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=600&h=600&fit=crop&crop=face",
        description: "Celebrating our diverse international student community",
    },
    {
        id: 9,
        title: "Class of 2023 Celebration",
        ceremony: "2023 Spring Graduation Ceremony",
        date: "July 20, 2023",
        category: "Ceremony",
        year: "2023",
        image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=600&fit=crop&crop=face",
        description: "Memorable moments from 2023 graduation",
    },
    {
        id: 10,
        title: "Research Excellence Awards 2023",
        ceremony: "2023 Research Awards Ceremony",
        date: "July 25, 2023",
        category: "Awards",
        year: "2023",
        image: "https://images.unsplash.com/photo-1494790108755-2616b612b494?w=600&h=600&fit=crop&crop=face",
        description: "Recognizing outstanding research contributions",
    },
    {
        id: 11,
        title: "Natural Sciences Graduation",
        ceremony: "2024 Sciences Department Ceremony",
        date: "July 22, 2024",
        category: "Department",
        departmentName: "Natural Sciences",
        departmentSlug: "natural-sciences",
        year: "2024",
        image: "https://images.unsplash.com/photo-1559548331-f9cb98001426?w=600&h=600&fit=crop&crop=face",
        description: "Science graduates ready to make discoveries",
    },
    {
        id: 12,
        title: "Social Sciences Recognition",
        ceremony: "2024 Social Sciences Graduation",
        date: "July 23, 2024",
        category: "Department",
        departmentName: "Social Sciences",
        departmentSlug: "social-sciences",
        year: "2024",
        image: "https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&h=600&fit=crop&crop=face",
        description: "Social sciences graduates ready to impact society",
    },
    {
        id: 13,
        title: "Dean's List Honorees",
        ceremony: "2024 Academic Honors Ceremony",
        date: "July 24, 2024",
        category: "Awards",
        year: "2024",
        image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=600&h=600&fit=crop&crop=face",
        description: "Honoring students with exceptional academic achievement",
    },
    {
        id: 14,
        title: "Graduate Studies Ceremony",
        ceremony: "2024 Masters & PhD Graduation",
        date: "July 25, 2024",
        category: "Ceremony",
        year: "2024",
        image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&h=600&fit=crop&crop=face",
        description: "Advanced degree recipients celebrating their research",
    },
    {
        id: 15,
        title: "Student Leadership Awards",
        ceremony: "2024 Leadership Recognition",
        date: "July 26, 2024",
        category: "Awards",
        year: "2024",
        image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=600&fit=crop&crop=center",
        description: "Recognizing outstanding student leadership",
    },
    {
        id: 16,
        title: "Alumni Achievement Awards",
        ceremony: "2023 Alumni Recognition",
        date: "August 15, 2023",
        category: "Awards",
        year: "2023",
        image: "https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=600&h=600&fit=crop&crop=face",
        description: "Celebrating successful alumni achievements",
    },
];

/**
 * Filter keys accepted by the gallery, mapped to the photo
 * categories (or years) they select.
 * @type {Record<string, {category?: string, year?: string}>}
 */
export const filterMap = {
    all: {},
    ceremony: { category: "Ceremony" },
    awards: { category: "Awards" },
    department: { category: "Department" },
    2024: { year: "2024" },
    2023: { year: "2023" },
};

/**
 * Filter photos by the given filter key.
 * @param {Photo[]} photos
 * @param {string} filterKey
 * @returns {Photo[]}
 */
export function filterPhotos(photos, filterKey) {
    const criteria = filterMap[filterKey];
    if (!criteria || (!criteria.category && !criteria.year)) {
        return photos;
    }
    return photos.filter(
        (photo) =>
            (criteria.category ? photo.category === criteria.category : true) &&
            (criteria.year ? photo.year === criteria.year : true),
    );
}

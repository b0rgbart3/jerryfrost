   const categoriesArray = ['figurative', 'social-commentary', 'abstract', 'landscape', 'animals'];

   function sortPaintingsByDate(paintings) {
    return paintings.sort(function (a, b) {
      // Compare years in reverse order
      const yearComparison = parseInt(b.year) - parseInt(a.year);
      
      // If the years are equal, compare months
      if (yearComparison === 0) {
        const monthOrder = {
          January: 1, February: 2, March: 3, April: 4,
          May: 5, June: 6, July: 7, August: 8,
          September: 9, October: 10, November: 11, December: 12
        };
  
        const monthComparison = monthOrder[b.month] - monthOrder[a.month];

        if (monthComparison ===0) {

            const dayComparison = parseInt(b.day) - parseInt(a.day)
            return dayComparison;
        }
        return monthComparison;
      }
  
      return yearComparison;
    });
  }
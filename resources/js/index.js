function setup(state, options, searchItems, labelAttribute) {
  return {
    state,
    options,
    searchItems,
    labelAttribute,
    searchQuery: '',
    showOptions: false,
    toggle (value) {
      if (this.state.some(item => item.id === value.id)) { // UNCHECKING
        this.state = this.state.filter(item => item.id !== value.id)
      } else { //CHECKING
        this.state.push({
          ...value,
          [labelAttribute]: value[labelAttribute].replace(/<(\/)?b>/g, ''),
        })
      }
    },
    searchResults () {
      const regex = new RegExp(this.searchQuery, 'i')

      return this.searchItems
        .filter(item => regex.test(item[labelAttribute]))
        .map(item => ({
          ...item,
          [labelAttribute]: item[labelAttribute].replace(regex, '<b>$&</b>')
        }))
    },
    clickOutsideClose () {
      this.showOptions = false
      this.searchQuery = ''
    }
  }
}
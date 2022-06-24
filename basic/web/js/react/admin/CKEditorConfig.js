CKEDITOR.stylesSet.add('newsEditorStyles', [
	{
		name: 'Content subtitle',
		element: 'p',
		attributes: { 'class': 'bookmark' }
	},
	{
		name: 'Content data',
		element: 'p'
	}
]);

CKEDITOR.stylesSet.add('analyticEditorStyles', [
	{
		name: 'Content part',
		element: 'h3',
		attributes: { 'id': 'part' }
	},
	{
		name: 'Content every part data',
		element: 'p',
		attributes: { 'id': 'matherial' }
	}
]);

CKEDITOR.stylesSet.add('eventEditorStyles', [
	{
		name: 'Event program data',
		element: 'table',
		attributes: { 'id': 'program' }
	},
	{
		name: 'Event program session data',
		element: 'ul',
		attributes: { 'id': 'primetime' }
	}, 
	{
		name: 'Event organizator web site',
		element: 'a',
		attributes: { 'id': 'organizatorContact' }
	}
]);

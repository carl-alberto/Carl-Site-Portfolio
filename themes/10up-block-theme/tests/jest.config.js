const config = {
	displayName: '10up-block-theme',
	preset: '10up-toolkit',
	testEnvironment: 'jsdom',
	setupFilesAfterEnv: ['<rootDir>/tests/jest/setup.js'],
	moduleNameMapping: {
		'^@wordpress/(.*)$': '<rootDir>/node_modules/@wordpress/$1',
	},
	testMatch: ['<rootDir>/tests/jest/**/*.test.js'],
};

module.exports = config;

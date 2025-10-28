/* eslint-disable */
/** @type {import('@jest/types').Config.InitialOptions} */
module.exports = {
	testEnvironment: 'jsdom',
	testEnvironmentOptions: {},
	testMatch: ['<rootDir>/tests/jest/**/*.test.[jt]s?(x)'],
	moduleNameMapper: {
		'^@blocks/(.*)$': '<rootDir>/blocks/$1',
		'\\.css$': 'identity-obj-proxy',
	},
	setupFilesAfterEnv: ['<rootDir>/tests/jest.setup.js'],
	transform: {
		'^.+\\.[jt]sx?$': 'babel-jest',
	},
	collectCoverageFrom: [
		'blocks/**/*.js',         // ✅ includes index.js and edit.js
		'!**/block.json',         // ❌ excludes metadata
		'!**/render.php',         // ❌ excludes PHP render files
	],
};

# How to contribute

##  Creation of commits

- Commit Header: {gitmoji} [ADD/FIX] #1234 Short summary
    - We use [gitmoji](https://gitmoji.carloscuesta.me/) in all commit headers to reflect the changes.
    - The gitmoji is followed by the information whether this is a new feature ([ADD]) or a fix ([FIX]). This is followed by a reference to the issue and a short summary.
- Commit Message:
    - Each commit message contains a description of the changes and new features as detailed as possible. At the end of the commit message, two line breaks are followed by a new reference to the issue (Resolves: #1234).

Example:
```
:bug: [FIX] #6 Fix bug in the recording of account balances

- An error occurred when trying to enter a new balance of a bank account.
- The error occurred because the bank account did not yet have an account balance and therefore, when calculating the differences, an attempt was made to access null object. This caused an exception, which made it impossible to enter the account balance.
- The solution includes checking whether the object is an instance of the model. If the object is an instance of the model, the calculation is performed, if not, the values to be calculated are set to 0.

Resolves: #6
```

## Request Feature

- Open an [Issues](https://github.com/elyday/manager/issues) with the label "feature request" and describe your proposal exactly and emphasize the added value of the new feature.
- If you receive positive feedback, the issue will be labeled "Enhancement" and "feature planned" and will be earmarked for development.

### You want to implement your feature yourself?

- If you want to implement your issue directly yourself, communicate this directly and clearly in the issue.
- Please wait until your issue gets the label "feature planned" before creating a pull request.
- The pull request should be linked to the issue. The description should also be meaningful.
- Please follow the guidelines for creating commits.

## You found a bug?

- First check if the bug has not already been reported ([Issues](https://github.com/elyday/manager/issues)).
- If the bug has not been reported yet, you can create a new issue. This issue should have a meaningful title that is related to the bug. The description should also be meaningful and include all the necessary steps to reproduce the bug.
- If possible, add an extract of the log including a possible stacktrace to the issue.
- A screenshot of the bug is also desired.

We will take a look at your issue and fix it as soon as possible.

### Have you already written a patch that fixes the bug?

- Follow the steps necessary to report an error.
- Create a GitHub pull request that only fixes the bug.
- Link the pull request to the created bug ticket. The description of the pull request should include information about the bug and its resolution.
- Please follow the guidelines for creating commits.
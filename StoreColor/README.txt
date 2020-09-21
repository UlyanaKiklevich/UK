The way it works:
    the command looks this way:

        bin/magento store:color --color="ffffff" --store=1

    color has a validation, and it's supposed to consist of either 3 or 6 letters, no # .
    store id has a validation as well.

    The command generates a .css file, its name contains store id - this is the way a file is applied to the specific store.

The dafault.xml adds a .phtml file into <head> and .phtml file adds <link> with the file for the specific store.

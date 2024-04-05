# Database-System-Project

## How to revert if your merge is incomplete
1. git fetch origin -> fetch the latest changes from the remote repository
2. git checkout main ->If you haven't already, check out the branch that contains the commits
3. git reset --hard &lt;last one perfectly workling &gt; -> reset the last perfect commit
4. git push origin main --force -> Force push
5. git pull origin main -> Update your local code
